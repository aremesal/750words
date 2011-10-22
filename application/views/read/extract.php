<?php $this->load->view('layout/partials/opencontent_for_logged'); ?>

<div id="dvWhatisthis" class="dvAbout">
    <h1>Extraer y descargar todos mis textos</h1>    
    <p>
        Puedes extraer todos tus textos para conservarlos fuera del sistema, o
        para llevártelos a otra aplicación. Dispones de varios formatos, escoje
        el que más útil te resulte.
        <br /><br />
    </p>
</div>
<div id="dvExtract">
    <form method="post" action="/read/extracttexts" id="fExtract">
        <fieldset id="fsExtract">
            <input type="radio" name="extracttype" value="html" checked />
            HTML
            <br />
            <input type="radio" name="extracttype" value="xml" />
            XML
            <br />
            <input type="radio" name="extracttype" value="pdf" />
            PDF
            <br /><br />
            <input type="submit" value="Generar y descargar" />
        </fieldset>
    </form>
</div>
<div id="dvExtractInfo" class="dvAbout">
    <dl>
        <dt>HTML</dt>
        <dd>Este formato es el más cómodo para leer en pantalla. Descargarás
        un fichero .html con un índice al inicio que enlaza a cada uno de los textos.</dd>
        <dt>XML</dt>
        <dd>Este formato es el adecuado para migrar tus textos a otro sistema externo. Se
        descargará un fichero .xml con los textos y fecha de cada uno de ellos.</dd>
        <dt>PDF</dt>
        <dd>Este formato es el más cómodo para imprimir o para leer en un lector de ebooks.
            Descargarás un fichero .pdf con todos tus textos.</dd>
    </dl>
</div>
<?php $this->load->view('layout/partials/closecontent_for_logged'); ?>

<?php $this->load->view('layout/partials/footer_for_logged'); ?>