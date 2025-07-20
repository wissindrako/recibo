<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('css/moodly-style.css')}}">
    <title>Verificación Recibo</title>
</head>
<body>   
  <div style="min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class="results-summary-container">
       <div class="confetti">
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
        <div class="confetti-piece"></div>
      </div>
      <div class="results-summary-container__result">
        <div class="heading-tertiary">Recibo</div>
        <div class="result-box">
          <p class="result">N°</p>
          <div class="heading-primary"> {{ $recibo->nro_serie }}</div>
        </div>
        <div class="result-text-box">
          <div class="heading-secondary">Verificado</div>
          <p class="paragraph">
            {{ $recibo->hash}}
          </p>
        </div>
      </div>
      <div class="results-summary-container__options">
        <div class="heading-secondary heading-secondary--blue">Resumen</div>
        <div class="summary-result-options">
          <div class="result-option result-option-reaction">
            <div class="result-box"><span>Cliente</span> :</div>
            <div class="icon-box">
              <span class="reaction-icon-text">{{ $recibo->cliente->titulo }} {{ $recibo->cliente->nombres }} {{ $recibo->cliente->ap_paterno }} {{ $recibo->cliente->ap_materno }}</span>
            </div>
            
          </div>
          <div class="result-option result-option-verbal" style="display: flex; align-items: center;">
            <div class="result-box"><span>Detalle</span> :</div>
            <div style="margin-left:auto; text-align:right; max-width:250px;">
              <span class="verbal-icon-text">{{ $recibo->concepto }}</span>
            </div>
          </div>
          <div class="result-option result-option-Visual">
            <div class="result-box"><span>Monto</span> :</div>
            <div class="icon-box">
              <span class="visual-icon-text"><strong> {{ $recibo->cantidad }}</strong></span>
            </div>
          </div>
          {{-- <div class="summary__cta">
            <button class="btn btn__continue">Volver</button>
          </div> --}}
          <br>
        </div>
      </div>
    </div>
  </div>
</body>
</html>