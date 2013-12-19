/**
 * Sharif Judge
 * @file shj_submissions.js
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 *
 *     Javascript codes for "All Submissions" and "Final Submissions" pages
 */

shj.modal_open = false;
$(document).ready(function () {
	$(document).on('click', '#select_all', function (e) {
		e.preventDefault();
		$('.code-column').selectText();
	});
	$(".btn").click(function () {
		var button = $(this);
		var row = button.parents('tr');
		if (button.data('shj') == 'download') {
			window.location = shj.site_url + 'submissions/download_file/' + row.data('u') + '/' + row.data('a') + '/' + row.data('p') + '/' + row.data('s');
			return;
		}
		var view_code_request = $.ajax({
			cache: true,
			type: 'POST',
			url: shj.site_url + 'submissions/view_code',
			data: {
				code: button.data('code'),
				username: row.data('u'),
				assignment: row.data('a'),
				problem: row.data('p'),
				submit_id: row.data('s'),
				shj_csrf_token: shj.csrf_token
			},
			success: function (data) {
				$(".modal_inside").html(data);
				$.syntax({
					blockLayout: 'fixed',
					theme: 'paper'
				});
			}
		});
		if (!shj.modal_open) {
			shj.modal_open = true;
			$('#shj_modal').reveal(
				{
					animationspeed: 300,
					on_close_modal: function () {
						view_code_request.abort();
					},
					on_finish_modal: function () {
						$(".modal_inside").html('<div style="text-align: center;">Loading<br><img src="'+shj.base_url+'assets/images/loading.gif"/></div>');
						shj.modal_open = false;
					}
				}
			);
		}

	});
	$(".shj_rejudge").attr('title', 'Rejudge');
	$(".shj_rejudge").click(function () {
		var row = $(this).parents('tr');
		$.post(
			shj.site_url + 'rejudge/rejudge_one',
			{
				username: row.data('u'),
				assignment: row.data('a'),
				problem: row.data('p'),
				submit_id: row.data('s'),
				shj_csrf_token: shj.csrf_token
			},
			function (data) {
				if (data == 'success') {
					row.children('.status').html('<div class="btn pending" data-code="0">PENDING</div>');
					noty({text: 'Rejudge in progress', layout: 'bottomRight', type: 'success', timeout: 2500});
				}
			}
		);
	});
	$(".set_final").click(
		function () {
			var row = $(this).parents('tr');
			var submit_id = row.data('s');
			var problem = row.data('p');
			var username = row.data('u');
			$.post(
				shj.site_url + 'submissions/select',
				{
					submit_id: submit_id,
					problem: problem,
					username: username,
					shj_csrf_token: shj.csrf_token
				},
				function (a) {
					if (a == "shj_success") {
						$("tr[data-u='" + username + "'][data-p='" + problem + "']").find('.set_final').removeClass('checked');
						$(".set_final#sf" + submit_id + "_" + problem).addClass('checked');
					}
					else if (a == "shj_finished") {
						noty({
							text: 'This assignment is finished. You cannot change your final submissions.',
							layout: 'bottomRight',
							type: 'warning',
							timeout: 5000,
							closeWith: ['click', 'button'],
							animation: {
								open: {height: 'toggle'},
								close: {height: 'toggle'},
								easing: 'swing',
								speed: 300
							}
						});
					}
				}
			);
		}
	);
});
