
<div id="stup_wrapper">


<div id="stup_showfiles">
<script>StupShowFiles();</script>
</div><!-- /stup_showfiles -->


<form id="stup_form" enctype="multipart/form-data" method="post">
	<p>Текст <input type="text" name="stup_text" value="Параметр из формы" /></p>
	<input type="file" name="stup_file[]" id="stup_file" multiple onchange="StupFileOnchange();" />
</form><!-- /stup_form -->

	
<div id="stup_progress_wrapper">
	<div id="stup_progress"></div>
</div><!-- /stup_progress_wrapper -->


<div id="stup_anime">
	<div id="stup_response">
		<div id="stup_message"></div>
		<div id="stup_output"></div>
	</div><!-- /stup_response -->
	<div id="stup_fader"></div>
</div><!-- /stup_anime -->

</div><!-- /stup_wrapper -->
