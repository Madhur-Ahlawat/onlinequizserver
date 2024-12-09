function displayLoader() {
	$("#dvloader").css('display', 'block');
	$("body").addClass('overlay');
}

function hideLoader() {
	$("#dvloader").css('display', 'none');
	$("body").removeClass('overlay');
}

function readURL(input, id, height_check = null, width_check = null) {
	if (input.files && input.files[0]) {
		$('.error_img').html('');
		var file_size = parseFloat((input.files[0].size / (1024 * 1024)).toFixed(2));
		if (file_size > 2) {
			$("#video_thumbnail").val("");
			$('.error_img').html('Image Size must be lessthan 2MB');
			return false;
		}
		var reader = new FileReader();
		reader.onload = function (e) {
			if (width_check) {
				var height = e.height;
				var width = e.width;
				if (height < height_check && width < width_check) {
					$('.error_img').html('Height and Width must' + height_check + ' x ' + width_check);
					return false;
				}
			}

			$('#' + id).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function removefile(imageFile) {
	imageFile.val('');
}


/************ cghunk video upload ***************/

var baseUrl = jQuery('#base_url').val();
var datafile = new plupload.Uploader({
	runtimes: 'html5,flash,silverlight,html4',
	browse_button: 'uploadFile', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	chunk_size: '1mb',
	url: baseUrl + 'admin/video/SavevideosChunk',
	filters: {
		max_file_size: '15mb',
	},

	max_file_count: 1,
	init: {
		PostInit: function () {
			var filelist = '';
			document.getElementById('filelist').innerHTML = '';
			document.getElementById('upload').onclick = function () {
				datafile.start();
				return false;
			};
		},

		FilesAdded: function (up, files) {
			var file_size = 0;
			$('#console').html('');
			$('#filelist').html('');
			if (files.length >= 1) {
				plupload.each(files, function (file) {
					file_size = parseFloat((file.size / (1024 * 1024)).toFixed(2));
					if (video_max_size >= file_size) {
						filelist = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
						$('#filelist').html(filelist);
					} else {
						filelist = '<div id="' + file.id + '"> <b>Size must be lessthan ' + video_max_size + ' MB</b></div>';
						$('#upload').hide("hide");
						$('#filelist').html(filelist);
						return false;
					}
				});
				// $('#uploader_browse').hide("slow"); //if greater than 5, hides the browse button
			} else {
				//up.settings.max_file_count = up.settings.max_file_count - files.length;
				// alert(up.settings.max_file_count); // Shows the max_file_count for test
			}

		},
		UploadProgress: function (up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			if (file.percent > 60) {
				jQuery('#mp3_file_name').val(file.name);
			}
		},
		Error: function (up, err) {
			if (err.message == 'File size error.') {
				$('#console').html('Size must be lessthan ' + video_max_size + ' MB');
			} else {

			}

		}
	}
});

datafile.init();
// datafile.bind('FilesAdded', function(up, files) {
//   var html = '';
//   plupload.each(files, function(file) {

//         // datafile.destroy()  
//   });

// });

/***********************************************/
