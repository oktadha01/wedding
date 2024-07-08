var resizeCover = function () {
	var $content = $('#coverFrame');
	var width = parseInt($content.outerWidth()) || 0;
	var radius = width + (width / 4);
	$content.css({
		borderRadius: radius
	});
	$content.find('.preview-container').css({
		borderRadius: radius
	});
}
var resizeStory = function () {
	var $picture = $('.story-item .story-picture');
	var width = parseInt($picture.outerWidth()) || 0;
	$picture.css({
		borderTopLeftRadius: width,
		borderTopRightRadius: width
	});
}
var eventContents = [];
var resizeEventContent = function () {
	$('.event-content').each(function (i, content) {
		var width = parseInt($(content).width()) || 0;
		var height = parseInt($(content).height()) || 0;
		var pillarHeight = 0;
		$(content).css({
			borderRadius: width
		});
		var activityHeight = parseInt($(content).find('.activity-wrap').height()) || 0;
		var eventDetailsHeight = parseInt($(content).find('.event-details').height()) || 0;
		var childrenHeight = activityHeight + eventDetailsHeight;
		var $pillar = $(content).find('.orn-pillar');
		if ($pillar.length) {
			var topHeight = $pillar.find('.pillar-top').height();
			var centerHeight = $pillar.find('.pillar-center').height();
			var bottomHeight = $pillar.find('.pillar-bottom').height();
			pillarHeight = (parseInt(topHeight) || 0) + (parseInt(centerHeight) || 0) + (parseInt(bottomHeight) || 0);
		}
		var selectedEvent;
		for (var i = 0; i < eventContents.length; i++) {
			if (eventContents[i]['element'] == content) {
				selectedEvent = eventContents[i];
				break;
			}
		}
		if (selectedEvent) {
			height = selectedEvent.height;
			pillarHeight = selectedEvent.pillarHeight;
		}
		if (height < pillarHeight) {
			return $(content).css({
				minHeight: pillarHeight - 0
			});
		}
		return $(content).css({
			minHeight: childrenHeight
		});
	});
}
var resizeWeddingGift = function () {
	var $content = $('.wedding-gift-inner');
	var width = $content.outerWidth();
	$content.css({
		'--border-radius': width + (width / 4) + 'px'
	});
}
var resizingElements = function () {
	resizeCover();
	resizeStory();
	resizeEventContent();
	resizeWeddingGift();
}
$(window).on('resize', function () {
	resizingElements();
});
$(document).ready(function () {
	$('.event-content').each(function (i, content) {
		var contentWidth = parseInt($(content).width()) || 0;
		var contentHeight = parseInt($(content).height()) || 0;
		var pillarHeight = 0;
		var activityHeight = parseInt($(content).find('.activity-wrap').height()) || 0;
		var eventDetailsHeight = parseInt($(content).find('.event-details').height()) || 0;
		var childrenHeight = activityHeight + eventDetailsHeight;
		var $pillar = $(content).find('.orn-pillar');
		if ($pillar.length) {
			var topHeight = $pillar.find('.pillar-top').height();
			var centerHeight = $pillar.find('.pillar-center').height();
			var bottomHeight = $pillar.find('.pillar-bottom').height();
			pillarHeight = (parseInt(topHeight) || 0) + (parseInt(centerHeight) || 0) + (parseInt(bottomHeight) || 0);
		}
		eventContents.push({
			element: content,
			width: contentWidth,
			height: contentHeight,
			childrenHeight: childrenHeight,
			pillarHeight: pillarHeight
		});
	});
	resizingElements();
});
