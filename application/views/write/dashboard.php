<?php $this->load->view('layout/partials/opencontent_for_logged'); ?>

<form method="post" action="/" id="fTodayText">
    <input type="hidden" name="uid" id="uid" value="<?=$uid?>" />
    <textarea name="text" id="text" class="typewritter" placeholder="Empieza a escribir aqu&iacute;"><?=$text?></textarea>
    <br />

    <span id="spFeedback">
        <span id="wordcount">Palabras: <span id="wordcount_count">0</span></span>
        
        <span id="finish">
            <input type="submit" value="Guardar ahora" />
        </span>
        
        <span id="saved">Guardado (<span id="spSaved_at"> <?=strftime('%H:%M:%S', $saved_at->sec)?></span> )</span>
    </span>
</form>

<?php $this->load->view('layout/partials/closecontent_for_logged'); ?>

<?php $this->load->view('layout/partials/footer_for_logged'); ?>