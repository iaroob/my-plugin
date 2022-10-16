jQuery(document).ready(function($){
	$(document).on('click', '.upload-button', function(){
		var mediaUploader;
		var elem = $(this);
	  // If the uploader object has already been created, reopen the dialog
		var id = elem.attr('name');
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}
	  mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
				text: 'Choose Image'
			}, multiple: false });

			mediaUploader.on('select', function() {
				attachment = mediaUploader.state().get('selection').first().toJSON();
				$('#img-'+id).val(attachment.url);
			});

	  // Open the uploader dialog
	  mediaUploader.open();
	});

});