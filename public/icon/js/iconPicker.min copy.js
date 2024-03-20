! function (e) {
	e.fn.iconPicker = function (t) {
		var o = !1,
			a = null,
			i = new Array("adjust", "alert", "align-center", "align-justify", "align-left", "align-right", "apple", "arrow-down", "arrow-left", "arrow-right", "arrow-up", "asterisk", "baby-formula", "backward", "ban-circle", "barcode", "bed", "bell", "bishop", "bitcoin", "blackboard", "bold", "book", "bookmark", "briefcase", "btc", "bullhorn", "calendar", "camera", "cd", "certificate", "check", "chevron-down", "chevron-left", "chevron-right", "chevron-up", "circle-arrow-down", "circle-arrow-left", "circle-arrow-right", "circle-arrow-up", "cloud", "cloud-download", "cloud-upload", "cog", "collapse-down", "collapse-up", "comment", "compressed", "console", "copy", "copyright-mark", "credit-card", "cutlery", "dashboard", "download", "download-alt", "duplicate", "earphone", "edit", "education", "eject", "envelope", "equalizer", "erase", "eur", "euro", "exclamation-sign", "expand", "export", "eye-close", "eye-open", "facetime-video", "fast-backward", "fast-forward", "file", "film", "filter", "fire", "flag", "flash", "floppy-disk", "floppy-open", "floppy-remove", "floppy-save", "floppy-saved", "folder-close", "folder-open", "font", "forward", "fullscreen", "gbp", "gift", "glass", "globe", "grain", "hand-down", "hand-left", "hand-right", "hand-up", "hd-video", "hdd", "header", "headphones", "heart", "heart-empty", "home", "hourglass", "ice-lolly", "ice-lolly-tasted", "import", "inbox", "indent-left", "indent-right", "info-sign", "italic", "jpy", "king", "knight", "lamp", "leaf", "level-up", "link", "list", "list-alt", "lock", "log-in", "log-out", "magnet", "map-marker", "menu-down", "menu-hamburger", "menu-left", "menu-right", "menu-up", "minus", "minus-sign", "modal-window", "move", "music", "new-window", "object-align-bottom", "object-align-horizontal", "object-align-left", "object-align-right", "object-align-top", "object-align-vertical", "off", "oil", "ok", "ok-circle", "ok-sign", "open", "open-file", "option-horizontal", "option-vertical", "paperclip", "paste", "pause", "pawn", "pencil", "phone", "phone-alt", "picture", "piggy-bank", "plane", "play", "play-circle", "plus", "plus-sign", "print", "pushpin", "qrcode", "queen", "question-sign", "random", "record", "refresh", "registration-mark", "remove", "remove-circle", "remove-sign", "repeat", "resize-full", "resize-horizontal", "resize-small", "resize-vertical", "retweet", "road", "rub", "ruble", "save", "save-file", "saved", "scale", "scissors", "screenshot", "sd-video", "search", "send", "share", "share-alt", "shopping-cart", "signal", "sort", "sort-by-alphabet", "sort-by-alphabet-alt", "sort-by-attributes", "sort-by-attributes-alt", "sort-by-order", "sort-by-order-alt", "sound-5-1", "sound-6-1", "sound-7-1", "sound-dolby", "sound-stereo", "star", "star-empty", "stats", "step-backward", "step-forward", "stop", "subscript", "subtitles", "sunglasses", "superscript", "tag", "tags", "tasks", "tent", "text-background", "text-color", "text-height", "text-size", "text-width", "th", "th-large", "th-list", "thumbs-down", "thumbs-up", "time", "tint", "tower", "transfer", "trash", "tree-conifer", "tree-deciduous", "triangle-bottom", "triangle-left", "triangle-right", "triangle-top", "unchecked", "upload", "usd", "user", "volume-down", "volume-off", "volume-up", "warning-sign", "wrench", "xbt", "yen", "zoom-in", "zoom-out"),
			n = e.extend({}, t);
		return this.each(function () {
			function t(t) {
				a = e("<div/>", {
					css: {
						top: t.offset().top + t.outerHeight() + 6,
						left: t.offset().left
					},
					"class": "icon-popup"
				}), a.html('<div class="ip-control"> 						          <ul> 						            <li><a href="javascript:;" class="btn" data-dir="-1"><span class="glyphicon  glyphicon-fast-backward"></span></a></li> 						            <li><input type="text" class="ip-search glyphicon  glyphicon-search" placeholder="Search" /></li> 						            <li><a href="javascript:;"  class="btn" data-dir="1"><span class="glyphicon  glyphicon-fast-forward"></span></a></li> 						          </ul> 						      </div> 						     <div class="icon-list"> </div> 					         ').appendTo("body"), a.addClass("dropdown-menu").show(), a.mouseenter(function () {
					o = !0
				}).mouseleave(function () {
					o = !1
				});
				var n = "",
					s = 0,
					c = 30;
				e(".ip-control .btn", a).click(function (t) {
					t.stopPropagation();
					var o = e(this).attr("data-dir");
					s += c * o, s = 0 > s ? 0 : s, 210 >= s + c ? e.each(e(".icon-list>ul li"), function (t) {
						t >= s && s + c > t ? e(this).show() : e(this).hide()
					}) : s = 180
				}), e(".ip-control .ip-search", a).on("keyup", function (o) {
					n != e(this).val() && (n = e(this).val(), "" == n ? l(i) : l(t, e(i).map(function (e, t) {
						return -1 != t.toLowerCase().indexOf(n.toLowerCase()) ? t : void 0
					}).get()))
				}), e(document).mouseup(function (e) {
					a.is(e.target) || 0 !== a.has(e.target).length || r()
				})
			}

			function r() {
				e(".icon-popup").remove()
			}

			function l(t, o) {
				$ul = e("<ul>");
				for (var i in o) $ul.append('<li><a href="#" title=' + o[i] + '><span class="glyphicon  glyphicon-' + o[i] + '"></span></a></li>');
				e(".icon-list", a).html($ul), e(".icon-list li a", a).click(function (o) {
					o.preventDefault();
					var a = e(this).attr("title");
					t.val("glyphicon glyphicon-" + a), r()
				})
			}
			element = this, n.buttonOnly || void 0 != e(this).data("iconPicker") || ($this = e(this).addClass("form-control"), $wraper = e("<div/>", {
				"class": "input-group"
			}), $this.wrap($wraper), $button = e('<span class="input-group-addon pointer"><i class="glyphicon  glyphicon-picture"></i></span>'), $this.after($button), function (e) {
				$button.click(function () {
					t(e), l(e, i)
				})
			}($this), e(this).data("iconPicker", {
				attached: !0
			}))
		})
	}
}(jQuery);