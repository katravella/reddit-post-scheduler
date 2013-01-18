(function() {
	if (typeof threadId == "undefined" || !threadId.length) return;
	fetchThread(threadId);

	function fetchThread(id) {
		$.ajax({
			url: baseUrl + "api/loadthread/" + id,
			type: "GET",
			dataType: "json",
			success: function(data) { 
				loadThread(data); 
			}
		});
	}

	function loadThread(thread) {		
		$("#subreddit").val(thread.subreddit);
		$("#title").val(thread.title);
		$("#contents").val(thread.source);
		$("#contents").trigger('mousedown');
	}
})();


$(function() {
	$('#contents').autosize();
});

$(function() {
	// Populate subreddit selector

	fetchSubreddits();
	$("#subreddit-refresh").click(function(e) {
		e.preventDefault();
		fetchSubreddits(true);
	});

	function fetchSubreddits(refresh) {
		var url = baseUrl + "api/all_bots_moderate" + (refresh === false ? "/0" : "");
		$.ajax({
			url: url,
			type: "GET",
			dataType: "json",
			success: function(data) {
				if (data.error) {
					onError(data.error, 'ok');
					return;
				}

				if (data.length) {
					populateSubreddits(data);
				}
			},
			error: function (jq, textStatus, error) {
				onError(error, textStatus);
			}
		});
	}

	function onError(error, textStatus) {
		console.log('Error while fetching moderated subreddits (' + textStatus + '): \n' + error);
	}

	function populateSubreddits(users) {
		var $subreddits = $("#subreddit");
		$subreddits.empty();
		if (!users || !users.length) return;

		for (var userIndex = 0; userIndex < users.length; userIndex++) {

			var user = users[userIndex];
			var username = user.username;
			var subreddits = user.moderates;

			var $userGroup = $("<optgroup>")
				.appendTo($subreddits)
				.attr({ value: username, label: username })
				;
			
			if (!subreddits) {
				$userGroup.attr('label', username + ' - no subreddits found');
				continue;
			}

			for (var subredditIndex = 0; subredditIndex < subreddits.length; subredditIndex++) {
				var subreddit = subreddits[subredditIndex];

				var $subreddit = $("<option>")
					.appendTo($userGroup)
					.val(subreddit.name)
					.text(subreddit.title + '(' + subreddit.url + ')')
					;
			}
		}

		var selected = $subreddits.data('selected');
		if (selected) {
			$subreddits.val(selected);
		}
	}

});


$(function() {
	// Load markdown from existing reddit post

	$("[href='#existingModal']").click(function (e) {
		$sourceElement.focus();
	});

	var $fetchSourceButton = $('#fetchsource');
	var $sourceElement = $('#source');
	var $resultElement = $('#contents');

	$fetchSourceButton.on('click', function(e) {
		var sourceUrl = $.trim($sourceElement.val());
		if (!sourceUrl) return;

		$.ajax({
			url: baseUrl + "/api/redditpost",
			type: "POST",
			dataType: "json",
			data: { url: sourceUrl },
			success: success,
			error: error,
		});
	});
	$fetchSourceButton.removeAttr('disabled');

	function success(data) {
		if (data.error) {
			return error(data);
		}

		loadPost(data);
	}

	function loadPost(data) {
		var $title = $("#title");
		var $subreddit = $("#subreddit");

		if (data.subreddit) {
			$subreddit.val(data.subreddit);
		}

		if (data.title) {
			$title.val(title);
		}

		if (data.selftext) {
			var resultText = $resultElement.val();
			if (resultText) { resultText += "\n\n"; }
			resultText += data.selftext;
			$resultElement.val(resultText);
		}


		// update markdown preview
		$resultElement.trigger('mousedown');
	}

	function error(data) {
		alert ("Error: " + data.error);
	}
});


$(function() {
	// Save post
	var $form = $("form#savethread");
	var $saveButton = $("#dosave");

	$form.on('submit', function(e) {
		save();
		e.preventDefault();
	});


	function save() {
		var selectedBot = $form.find('#subreddit option:selected').closest('optgroup').attr('value');
		var $bot_username = $form.find("[name='bot_username']");
		if (!$bot_username.length) { 
			$bot_username = $('<input>', { type: 'hidden', name: 'bot_username'}).appendTo($form);
		}
		$bot_username.val(selectedBot);

		var data = $form.serialize();
		

		$.ajax({
			url: baseUrl + 'api/save/' + (threadId || ''),
			type: $form.attr('method').toUpperCase(),
			dataType: "json",
			data: data,
			success: function(data) { onSave(data); },
			error: function (jq, textStatus, error) { onError(error); }
		});
	}

	function onSave(data) {
		if (data.errors) {
			showErrors(data.error);
		} else if (data.hasOwnProperty('id') && data.id != null) {
			var threadId = data.id;
			$saveButton.text("Redirecting ...");
			window.location.href = baseUrl + 'thread/schedule/' + threadId;
		}
	}

	function showErrors(errors) {
		$form.find('.error').remove();

		for (var errorIndex in errors) {
			if (!errors.hasOwnProperty(errorIndex)) continue;
			var error = error[errorIndex];

			var $control = $form.find('[name="' + errorIndex + '"]');
			
			var $error = makeErrorElement(error);;
			var $container = $control.length 
				? $control.closest('.control-group')
				: $form;
			$container.append($error);
		}
	}

	function makeErrorElement(error) {

	}

	function onError(error) {
		debugger;
	}
});