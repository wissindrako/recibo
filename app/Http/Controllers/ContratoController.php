<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\Splade\Facades\Splade;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Barryvdh\DomPDF\Facade\Pdf;

class ContratoController extends Controller
{
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('descripcion_bien', 'LIKE', "%{$value}%")
                        ->orWhere('tipo', 'LIKE', "%{$value}%")
                        ->orWhereHas('arrendador', function ($q) use ($value) {
                            $q->where('nombre', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('persona', function ($q) use ($value) {
                            $q->where('nombres', 'LIKE', "%{$value}%")
                              ->orWhere('ap_paterno', 'LIKE', "%{$value}%")
                              ->orWhere('ap_materno', 'LIKE', "%{$value}%");
                        });
                });
            });
        });

        $query = Contrato::with('persona')->orderBy('created_at', 'desc');

        $contratos = QueryBuilder::for($query)
            ->defaultSort('-created_at')
            ->allowedSorts(['tipo', 'fecha_inicio', 'fecha_fin', 'monto'])
            ->allowedFilters(['tipo', $globalSearch])
            ->paginate()
            ->withQueryString();

        return view('contrato.index', [
            'contratos' => SpladeTable::for($contratos)
                ->withGlobalSearch()
                ->column(key: 'nro_serie', label: 'Nº')
                ->column('tipo', label: 'Tipo', sortable: true)
                ->column('persona.nombre_completo', label: 'Persona')
                ->column('fecha_inicio', label: 'Inicio', sortable: true)
                ->column('fecha_fin', label: 'Fin', sortable: true)
                ->column('monto', label: 'Monto Bs.', sortable: true)
                ->column('estado', label: 'Estado')
                ->column('action', label: 'Acciones'),
        ]);
    }

    public function create()
    {
        $personas = $this->getPersonasClientes();
        $arrendadores = $this->getArrendadoresActivos();
        $ultimo = Contrato::orderBy('created_at', 'desc')->first();
        return view('contrato.create', compact('personas', 'arrendadores', 'ultimo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo'               => 'required|in:alquiler,venta,otro',
            'arrendador_id'      => 'required|integer|exists:users,id',
            'persona_id'         => 'required|integer|exists:personas,id',
            'descripcion_inmueble'  => 'required|string',
            'descripcion_alquiler'  => 'required|string',
            'fecha_inicio'       => 'required|date',
            'fecha_fin'          => 'nullable|date|after_or_equal:fecha_inicio',
            'monto'              => 'required|numeric|min:0',
            'garantia'           => 'nullable|numeric|min:0',
            'dia_limite_pago'    => 'nullable|integer|min:1|max:31',
            'notas'              => 'nullable|string',
            'contrato_origen_id' => 'nullable|integer|exists:contratos,id',
        ]);

        try {
            DB::beginTransaction();

            $contrato = new Contrato();
            $contrato->nro_serie         = Contrato::nextNumeroSerie();
            $contrato->tipo              = $request->tipo;
            $contrato->arrendador_id     = $request->arrendador_id;
            $contrato->persona_id        = $request->persona_id;
            $contrato->descripcion_inmueble = $request->descripcion_inmueble;
            $contrato->descripcion_alquiler = $request->descripcion_alquiler;
            $contrato->fecha_inicio      = $request->fecha_inicio;
            $contrato->fecha_fin         = $request->fecha_fin;
            $contrato->monto             = $request->monto;
            $contrato->garantia          = $request->garantia;
            $contrato->dia_limite_pago   = $request->dia_limite_pago;
            $contrato->notas             = $request->notas;
            $contrato->contrato_origen_id = $request->contrato_origen_id;
            $contrato->estado            = 1;
            $contrato->user_id           = auth()->user()->id;
            $contrato->save();

            DB::commit();

            Splade::toast('Contrato creado correctamente!')->autoDismiss(5);
            return redirect()->route('contratos');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function show($id, Request $request)
    {
        $contrato = Contrato::with(['arrendador.persona', 'persona', 'usuario', 'contratoOrigen'])->findOrFail($id);

        if ($request->reporte === 'pdf') {
            $pdf = Pdf::loadView('contrato.reporte', compact('contrato'))
                ->setPaper('letter', 'portrait');
            $pdf->render();
            return $pdf->stream('Contrato-' . $contrato->nro_serie . '.pdf', ['Attachment' => false]);
        }

        return view('contrato.show', compact('contrato'));
    }

    public function edit($id)
    {
        $personas = $this->getPersonasClientes();
        $arrendadores = $this->getArrendadoresActivos();
        $contrato = Contrato::findOrFail($id);
        return view('contrato.edit', compact('contrato', 'personas', 'arrendadores'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tipo'               => 'required|in:alquiler,venta,otro',
            'arrendador_id'      => 'required|integer|exists:users,id',
            'persona_id'         => 'required|integer|exists:personas,id',
            'descripcion_inmueble'  => 'required|string',
            'descripcion_alquiler'  => 'required|string',
            'fecha_inicio'       => 'required|date',
            'fecha_fin'          => 'nullable|date|after_or_equal:fecha_inicio',
            'monto'              => 'required|numeric|min:0',
            'garantia'           => 'nullable|numeric|min:0',
            'dia_limite_pago'    => 'nullable|integer|min:1|max:31',
            'notas'              => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $contrato = Contrato::findOrFail($id);
            $contrato->tipo              = $request->tipo;
            $contrato->arrendador_id     = $request->arrendador_id;
            $contrato->persona_id        = $request->persona_id;
            $contrato->descripcion_inmueble = $request->descripcion_inmueble;
            $contrato->descripcion_alquiler = $request->descripcion_alquiler;
            $contrato->fecha_inicio      = $request->fecha_inicio;
            $contrato->fecha_fin         = $request->fecha_fin;
            $contrato->monto             = $request->monto;
            $contrato->garantia          = $request->garantia;
            $contrato->dia_limite_pago   = $request->dia_limite_pago;
            $contrato->notas             = $request->notas;

            $contrato->save();

            DB::commit();

            Splade::toast('Contrato actualizado correctamente!')->autoDismiss(5);
            return redirect()->route('contratos');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    /** Sube uno o varios archivos al contrato (acumula, no reemplaza). */
    public function uploadArchivos(Request $request, $id)
    {
        $request->validate([
            'archivos'   => 'required|array|min:1',
            'archivos.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,webp,gif|max:20480',
        ], [
            'archivos.required'   => 'Selecciona al menos un archivo.',
            'archivos.*.mimes'    => 'Solo se permiten PDF, Word e imágenes.',
            'archivos.*.max'      => 'Cada archivo no puede superar 20 MB.',
        ]);

        $contrato  = Contrato::findOrFail($id);
        $existentes = (array) ($contrato->archivo ?? []);

        foreach ($request->file('archivos') as $file) {
            if ($file->isValid()) {
                $existentes[] = $this->processFile($file);
            }
        }

        $contrato->archivo = $existentes;
        $contrato->save();

        return redirect()->route('contrato.edit', $contrato)
            ->with('success', 'Archivo(s) agregado(s) correctamente.')
            ->withFragment('archivos');
    }

    /** Elimina un archivo específico del contrato por su índice. */
    public function deleteArchivo(Request $request, $id, $index)
    {
        $contrato  = Contrato::findOrFail($id);
        $archivos  = (array) ($contrato->archivo ?? []);

        if (!isset($archivos[$index])) {
            return redirect()->route('contrato.edit', $contrato);
        }

        Storage::disk('public')->delete($archivos[$index]);
        array_splice($archivos, $index, 1);

        $contrato->archivo = empty($archivos) ? null : array_values($archivos);
        $contrato->save();

        return redirect()->route('contrato.edit', $contrato)
            ->with('success', 'Archivo eliminado.')
            ->withFragment('archivos');
    }

    private function getArrendadoresActivos()
    {
        return User::role('arrendador')
            ->with('persona')
            ->get();
    }

    private function getPersonasClientes()
    {
        return Persona::whereDoesntHave('user', fn($q) => $q->role('arrendador'))
            ->orWhereNull('user_id')
            ->orderBy('ap_paterno')
            ->get();
    }

    public function anular($id)
    {
        $contrato = Contrato::findOrFail($id);
        $contrato->estado = 0;
        $contrato->save();
        Splade::toast('Contrato anulado.')->autoDismiss(5);
        return redirect()->route('contratos');
    }

    public function renovar($id)
    {
        $personas = $this->getPersonasClientes();
        $arrendadores = $this->getArrendadoresActivos();
        $origen = Contrato::with('persona')->findOrFail($id);
        return view('contrato.create', [
            'personas'    => $personas,
            'arrendadores'=> $arrendadores,
            'ultimo'      => null,
            'origen'      => $origen,
        ]);
    }

    /**
     * Extrae los archivos subidos del request y los almacena.
     * Soporta tanto archivo (simple) como archivo[0], archivo[1]... (múltiple).
     */
    private function storeFiles(Request $request): array
    {
        $paths = [];
        $files = $request->file('archivo');

        if (empty($files)) {
            return $paths;
        }

        foreach ((array) $files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $paths[] = $this->processFile($file);
            }
        }

        return $paths;
    }

    /** Procesa un archivo: redimensiona si es imagen y GD está disponible, o almacena directo. */
    private function processFile(UploadedFile $file): string
    {
        $imageExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower($file->getClientOriginalExtension());

        if (in_array($ext, $imageExts) && extension_loaded('gd')) {
            return $this->resizeAndStore($file, $ext);
        }

        return $file->store('contratos', 'public');
    }

    /** Redimensiona una imagen (máx. 1920px ancho) y la guarda. */
    private function resizeAndStore(UploadedFile $file, string $ext): string
    {
        $maxWidth = 1920;
        $quality  = 85;

        $src = match ($ext) {
            'jpg', 'jpeg' => @\imagecreatefromjpeg($file->getRealPath()),
            'png'         => @\imagecreatefrompng($file->getRealPath()),
            'gif'         => @\imagecreatefromgif($file->getRealPath()),
            'webp'        => @\imagecreatefromwebp($file->getRealPath()),
            default       => false,
        };

        // Si GD no puede cargarla, guardar como está
        if (!$src) {
            return $file->store('contratos', 'public');
        }

        $origW = \imagesx($src);
        $origH = \imagesy($src);

        if ($origW > $maxWidth) {
            $newH = (int) round($origH * $maxWidth / $origW);
            $dst  = \imagecreatetruecolor($maxWidth, $newH);

            if ($ext === 'png') {
                \imagealphablending($dst, false);
                \imagesavealpha($dst, true);
            }

            \imagecopyresampled($dst, $src, 0, 0, 0, 0, $maxWidth, $newH, $origW, $origH);
            \imagedestroy($src);
            $src = $dst;
        }

        $outputExt = ($ext === 'png') ? 'png' : 'jpg';
        $filename  = uniqid('img_', true) . '.' . $outputExt;
        $tempPath  = \sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

        if ($outputExt === 'png') {
            \imagepng($src, $tempPath, 8);
        } else {
            \imagejpeg($src, $tempPath, $quality);
        }

        \imagedestroy($src);

        $stored = Storage::disk('public')->putFileAs('contratos', new File($tempPath), $filename);
        @\unlink($tempPath);

        return $stored;
    }
}
