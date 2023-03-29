<x-splade-select name="cliente_id"
label="Cliente" :options="$clientes" option-label="nombre_completo" option-value="id"/>

<x-splade-input name="fecha" label="Fecha" date required/>
<x-splade-input name="cantidad" label="La suma de:" type="number" min="0" step="0.01" required/>
<x-splade-input name="concepto" label="Por concepto de:" required/>

<x-splade-select name="user_id"
label="Usuario" :options="$usuarios" option-label="name" option-value="id"/>

<x-splade-submit label="Enviar"/>
