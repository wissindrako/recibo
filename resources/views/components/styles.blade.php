<style type="text/css">
    body {
        color: black;
        background-color: #ffffff;
    }

    text {
        font-size: 10px;
        text-align: center
    }


    #watermark {
        position: fixed;
        opacity: 0.15;
        /**
            Set a position in the page for your image
            This should center it vertically
        **/
        bottom:   10cm;
        left:     3.5cm;

        /** Change image dimensions**/
        width:    12cm;
        height:   12cm;

        /** Your watermark should be behind every content**/
        z-index:  -1000;
    }

    .datos {
        width: 750px;
        margin-left: -90px;
        margin-top: 20px;
        padding: 0px;
        font-size: 11px;
    }

    .cabecera {
        /* border-style: solid;
        border-color: #076ba5;
        border-width: 1px;
        border-radius: 5px; */
        background-color: #03a8f42f;
        border-left: 6px solid rgba(17, 188, 235, 0.676);
        margin-bottom: 0px;
    }

    .nro_serie {
        border-style: solid;
        border-color: #000000;
        border-width: 1px;
        border-radius: 5px;
        width: 100px;
        height: 34px;
        float: right;
        text-align: right;
        padding: 5px;
        margin-bottom: 0px;
        text-size: 15px;
    }

    .espacio_serie {
        padding-top: 10px;
        padding-boton: 10px;
        padding-left: 10px;
    }

    .titulo {
        width: 200px;
        float: left;
        text-align: center;
    }

    .fecha {
        width: 360px;
        float: right;
        font-size: 10px;
    }

    td.datos {
        width: 180px;
    }

    .espacio {
        padding-top: 10px;
        padding-boton: 10px;
        padding-left: 10px;
    }

    .informe {
        font-size: 12px;
        margin-left: 20px;
    }

    .supidc {
        vertical-align: super; /*superindice*/
    }

    .subidc {
        vertical-align: sub; /*subindice*/
    }

    .nivel {
        font-size: 16px;
        overflow: hidden;
        line-height: 0.7cm;
        height: 130px;
    }


    .justificado {
        text-align: justify;
    }

    /* .container{
        margin-top: 150px;
    } */
    /* @page { margin-top: 120px; margin-bottom: 120px} */
    @page { margin: 100px 55px; }
    header {
        position: fixed; left: 0px; top: -70px; right: 0px; height: 80px; text-align: center;
    }
    footer {
        /* position: fixed; left: 0px; bottom: -30px; right: 0px; height: 50px; */
        position: fixed;
        bottom: -40px;
        left: -20px;
        right: 0px;
        height: 60px;
        /* background-color: #03a8f486;
        color: white; */
        text-align: center;
        line-height: 1.2rem;
    }
</style>
