<?php

/**
 * Description of read
 *
 * @author remroyal
 */
class Read extends CI_Controller {

    private $userdata = NULL;

    public function  __construct() {
        parent::__construct();

        if( $this->session->userdata('uid') ) {
            $this->userdata = json_decode( encrypt_safedecode($this->session->userdata('uid')) );
        }
        else {
            redirect('/');
            return;
        }

        $this->layout->setLayout('layout/layout');
    }

    public function index() {

        $data = array();

        $this->layout->view('read/calendarview', $data);
    }

    public function getTextByDay() {
        $this->load->model('textsmodel');
        $text = $this->textsmodel->getTodayTextByDate($this->userdata->_id, strftime('%Y-%m-%d',strtotime( $this->input->post('date'))));

        $ret = array();
        $strNoText = 'El d&iacute;a '.strftime('%d de %B (%Y)',strtotime( $this->input->post('date'))).' no escribiste nada';

        if($text == NULL){
            setlocale(LC_TIME, "es_ES");
            $ret['text'] = $strNoText;
            $ret['count'] = 0;
        }
        else {
            $ret['text'] = strlen($text['text']) > 0 ? nl2br($text['text']) : $strNoText;
            $ret['count'] = $text['count'];
        }

        echo json_encode($ret);
    }

    public function extract() {
        $data = array();

        $this->layout->view('read/extract', $data);
    }

    public function extracttexts() {

        $ext = 'html';

        $this->load->model('textsmodel');

        // Get all texts for this user
        $texts = $this->textsmodel->getTextsByUser($this->userdata->_id);
        
        switch ($this->input->post('extracttype')) {
            case 'html':
                $ext = 'html';
                $mime = 'text/html';
                $file = $this->generateHTML($ext, $texts);
                break;
            case 'xml':
                $ext = 'xml';
                $mime = 'text/xml';
                $file = $this->generateXML($ext, $texts);
                break;
            case 'pdf':
                $ext = 'pdf';
                $mime = 'application/pdf';
                $file = $this->generatePDF($ext, $texts);
                break;

            default:
                $ext = 'html';
                $mime = 'text/html';
                $file = $this->generateHTML($ext);
                break;
        }

        $root = "tmp/";        
        $path = $root.$file;
        $type = '';

        $size = filesize($path);
        /* Not working in Windows:
        if (function_exists('mime_content_type')) {
            $type = mime_content_type($path);
        } else if (function_exists('finfo_file')) {
            $info = finfo_open(FILEINFO_MIME);
            $type = finfo_file($info, $path);
            finfo_close($info);
        }
        
        if ($type == '') {
            $type = "application/force-download";
        }
        */
        $type = $mime;

        header("Content-Type: $type");
        header("Content-Disposition: attachment; filename=textos.$ext");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $size);

        readfile($path);

        unlink($path);
    }

    private function generateHTML($type, $texts) {
        
        // Generate HTML
        $content = '';

        // Index
        $content .= <<<STYLE
<style>
body {width: 80%; border: 1px solid #EEE;}
p {padding: 16px; text-align: justify;}
h1 {padding: 10px;}
h2 {padding: 10px; margin-top: 30px;}
a {color: #555555;}
</style>
STYLE;
        $content .= '<h1>&Iacute;ndice</h1><p>';
        foreach( $texts as $text ) {
            if( strlen($text['text']) > 0 ) {
                $content .= '<a href="#'.$text['created_at'].'">Texto del '.nl2br(strftime('%d/%m/%Y', strtotime($text['created_at']))).'</a><br />';
            }
        }
        $content .= '</p>';

        // Texts
        foreach( $texts as $text ) {
            if( strlen($text['text']) > 0 ) {
                $content .= '<a name="'.$text['created_at'].'"/>';
                $content .= '<h2>Texto del '.nl2br(strftime('%d/%m/%Y', strtotime($text['created_at']))).'</h2>';
                $content .= '<p>'.nl2br($text['text']).'</p>';
            }
        }

        // Write file
        $file = $this->writeExtractFile($content, $type);

        return $file;
    }

    private function generateXML($type, $texts) {
        
        // Generate XML
        $content = '';

        $doc = new DOMDocument();
        $doc->formatOutput = true;
        
        $root = $doc->createElement("xml");
        $r = $doc->createElement("texts");
        $doc->appendChild( $root );
        $root->appendChild( $r );
  
        foreach( $texts as $text ) {
            if( strlen($text['text']) > 0 ) {
                $b = $doc->createElement( "text" );

                // Date
                $a = $doc->createAttribute( "date" );
                $a->appendChild( $doc->createTextNode( $text['created_at'] ) );
                $b->appendChild( $a );

                // Words
                $w = $doc->createAttribute( "count" );
                $w->appendChild( $doc->createTextNode( $text['count'] ) );
                $b->appendChild( $w );

                // Text
                $b->appendChild( $doc->createTextNode( $text['text'] ) );
                $r->appendChild( $b );
            }
        }

        $content = $doc->saveXML();
        //$doc->save("write.xml");

        // Write file
        $file = $this->writeExtractFile($content, $type);

        return $file;
    }

    private function generatePDF($type, $texts){
        include ('../application/third_party/class.ezpdf.php');
        $pdf = new Cezpdf();
        $pdf->selectFont('../application/third_party/fonts/Helvetica.afm');

        $pdf->ezText('750 palabras', 26);
        $pdf->ezText('', 26);

        foreach( $texts as $text ) {
            if( strlen($text['text']) > 0 ) {
                $pdf->ezText('Texto del '.nl2br(strftime('%d/%m/%Y', strtotime($text['created_at']))), 18);
                $pdf->ezText('', 18);
                $pdf->ezText($text['text'], 12);
                $pdf->ezText('', 18);
                $pdf->ezText('', 18);
            }
        }

        $pdf->ezStream();
    }

    private function writeExtractFile($content, $ext) {
        $file = encrypt_safeencode($this->userdata->_id . strftime('%Y-%m-%d %T')) . '.' . $ext;
        $root = "tmp/";
        $path = $root.$file;

        $fp = fopen($path, 'w+');
        fwrite($fp, $content);
        fclose($fp);

        return $file;
    }
}
?>
