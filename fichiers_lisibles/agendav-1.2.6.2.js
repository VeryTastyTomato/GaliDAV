/**
 * Freeow!
 * Stylish, Growl-like message boxes
 *
 * Copyright (c) 2011 PJ Dietz
 * Version: 1.00
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * http://pjdietz.com/jquery-plugins/freeow/
 */ (function($) {
	"use strict";
	var Freeow;
	Freeow = function(title, message, options) {
		var startStyle, i, u;
		this.options = $.extend({}, $.fn.freeow.defaults, options);
		this.element = $(this.options.template(title, message));
		if (this.options.startStyle) {
			startStyle = this.options.startStyle;
		} else {
			startStyle = this.options.hideStyle;
		}
		this.element.css(startStyle);
		this.element.data("freeow", this);
		for (i = 0, u = this.options.classes.length; i < u; i += 1) {
			this.element.addClass(this.options.classes[i]);
		}
		this.element.click(this.options.onClick);
		this.element.hover(this.options.onHover);
		this.autoHide = false;
	};
	Freeow.prototype = {
		attach: function(container) {
			$(container).prepend(this.element);
			this.show();
		},
		show: function() {
			var opts, self, fn, delay;
			opts = {
				duration: this.showDuration
			};
			if (this.options.autoHide && this.options.autoHideDelay > 0) {
				this.autoHide = true;
				self = this;
				delay = this.options.autoHideDelay;
				fn = function() {
					if (self.autoHide) {
						self.hide();
					}
				};
				opts.complete = function() {
					setTimeout(fn, delay);
				};
			}
			this.element.animate(this.options.showStyle, opts);
		},
		hide: function() {
			var self = this;
			this.element.animate(this.options.hideStyle, {
				duration: this.options.hideDuration,
				complete: function() {
					self.destroy();
				}
			});
		},
		destroy: function() {
			this.element.data("freeow", undefined);
			this.element.remove();
		}
	};
	if (typeof $.fn.freeow === "undefined") {
		$.fn.extend({
			freeow: function(title, message, options) {
				return this.each(function() {
					var f;
					f = new Freeow(title, message, options);
					f.attach(this);
				});
			}
		});
		$.fn.freeow.defaults = {
			autoHide: true,
			autoHideDelay: 3000,
			classes: [],
			startStyle: null,
			showStyle: {
				opacity: 1.0
			},
			showDuration: 250,
			hideStyle: {
				opacity: 0.0
			},
			hideDuration: 500,
			onClick: function(event) {
				$(this).data("freeow").hide();
			},
			onHover: function(event) {
				$(this).data("freeow").autoHide = false;
			},
			template: function(title, message) {
				var e;
				e = ['<div>', '<div class="background">', '<div class="content">', '<h2>' + title + '</h2>', '<p>' + message + '</p>', '</div>', '</div>', '<span class="icon"></span>', '<span class="close"></span>', '</div>'].join("");
				return e;
			}
		};
	}
}(jQuery));
/*

 FullCalendar v1.5.3-rcube-0.7.1
 https://github.com/roundcube/fullcalendar

 Use fullcalendar.css for basic styling.
 For event drag & drop, requires jQuery UI draggable.
 For event resizing, requires jQuery UI resizable.

 Copyright (c) 2011 Adam Shaw
 Copyright (c) 2011, Kolab Systems AG
 Dual licensed under the MIT and GPL licenses, located in
 MIT-LICENSE.txt and GPL-LICENSE.txt respectively.

 Date: Wed Mar 21 22:49:40 2012 +0100

*/
(function(o, sa) {
	function Ab(a) {
		o.extend(true, $a, a)
	}
	function $b(a, b, g) {
		function c(l) {
			if (H) {
				u();
				R();
				aa();
				O(l)
			} else f()
		}
		function f() {
			P = b.theme ? "ui" : "fc";
			a.addClass("fc");
			b.isRTL && a.addClass("fc-rtl");
			b.theme && a.addClass("ui-widget");
			H = o("<div class='fc-content' style='position:relative'/>").prependTo(a);
			y = new ac(A, b);
			(Q = y.render()) && a.prepend(Q);
			r(b.defaultView);
			o(window).resize(la);
			d() || k()
		}
		function k() {
			setTimeout(function() {
				!i.start && d() && O()
			}, 0)
		}
		function q() {
			o(window).unbind("resize", la);
			y.destroy();
			H.remove();
			a.removeClass("fc fc-rtl ui-widget")
		}
		function h() {
			return ma.offsetWidth !== 0
		}
		function d() {
			return o("body")[0].offsetWidth !== 0
		}
		function r(l) {
			if (!i || l != i.name) {
				m++;
				ja();
				var s = i,
					da;
				if (s) {
					(s.beforeHide || Bb)();
					ab(H, H.height());
					s.element.hide()
				} else ab(H, 1);
				H.css("overflow", "hidden");
				if (i = F[l]) i.element.show();
				else i = F[l] = new Ha[l](da = ya = o("<div class='fc-view fc-view-" + l + "' style='position:absolute'/>").appendTo(H), A);
				s && y.deactivateButton(s.name);
				y.activateButton(l);
				O();
				H.css("overflow", "");
				s && ab(H, 1);
				da || (i.afterShow || Bb)();
				m--
			}
		}
		function O(l) {
			if (h()) {
				m++;
				ja();
				fa === sa && u();
				var s = false;
				if (!i.start || l || t < i.start || t >= i.end) {
					i.render(t, l || 0);
					B(true);
					s = true
				} else if (i.sizeDirty) {
					i.clearEvents();
					B();
					s = true
				} else if (i.eventsDirty) {
					i.clearEvents();
					s = true
				}
				i.sizeDirty = false;
				i.eventsDirty = false;
				ea(s);
				ga = a.outerWidth();
				y.updateTitle(i.title);
				l = new Date;
				l >= i.start && l < i.end ? y.disableButton("today") : y.enableButton("today");
				m--;
				i.trigger("viewDisplay", ma)
			}
		}
		function L() {
			R();
			if (h()) {
				u();
				B();
				ja();
				i.clearEvents();
				i.trigger("viewRender", i);
				i.renderEvents(X);
				i.sizeDirty = false
			}
		}
		function R() {
			o.each(F, function(l, s) {
				s.sizeDirty = true
			})
		}
		function u() {
			fa = b.contentHeight ? b.contentHeight : b.height ? b.height - (Q ? Q.height() : 0) - Ua(H) : Math.round(H.width() / Math.max(b.aspectRatio, 0.5))
		}
		function B(l) {
			m++;
			i.setHeight(fa, l);
			if (ya) {
				ya.css("position", "relative");
				ya = null
			}
			i.setWidth(H.width(), l);
			m--
		}
		function la() {
			if (!m) if (i.start) {
				var l = ++j;
				setTimeout(function() {
					if (l == j && !m && h()) if (ga != (ga = a.outerWidth())) {
						m++;
						L();
						i.trigger("windowResize",
						ma);
						m--
					}
				}, 200)
			} else k()
		}
		function ea(l) {
			if (!b.lazyFetching || ha(i.visStart, i.visEnd)) na();
			else l && V()
		}
		function na(l) {
			E(i.visStart, i.visEnd, l)
		}
		function T(l) {
			X = l;
			V()
		}
		function N(l) {
			V(l)
		}
		function V(l) {
			aa();
			if (h()) {
				i.clearEvents();
				i.trigger("viewRender", i);
				i.renderEvents(X, l);
				i.eventsDirty = false
			}
		}
		function aa() {
			o.each(F, function(l, s) {
				s.eventsDirty = true
			})
		}
		function Z(l, s, da) {
			i.select(l, s, da === sa ? true : da)
		}
		function ja() {
			i && i.unselect()
		}
		function v() {
			O(-1)
		}
		function C() {
			O(1)
		}
		function ba() {
			jb(t, -1);
			O()
		}
		function W() {
			jb(t,
			1);
			O()
		}
		function w() {
			t = new Date;
			O()
		}
		function p(l, s, da) {
			if (l instanceof Date) t = G(l);
			else Cb(t, l, s, da);
			O()
		}
		function I(l, s, da) {
			l !== sa && jb(t, l);
			s !== sa && kb(t, s);
			da !== sa && ka(t, da);
			O()
		}
		function Y() {
			return G(t)
		}
		function ca() {
			return i
		}
		function e(l, s) {
			if (s === sa) return b[l];
			if (l == "height" || l == "contentHeight" || l == "aspectRatio") {
				b[l] = s;
				L()
			} else if (l.indexOf("list") == 0 || l == "tableCols") {
				b[l] = s;
				i.start = null
			} else if (l == "maxHeight") b[l] = s
		}
		function M(l, s) {
			if (b[l]) return b[l].apply(s || ma, Array.prototype.slice.call(arguments,
			2))
		}
		var A = this;
		A.options = b;
		A.render = c;
		A.destroy = q;
		A.refetchEvents = na;
		A.reportEvents = T;
		A.reportEventChange = N;
		A.rerenderEvents = V;
		A.changeView = r;
		A.select = Z;
		A.unselect = ja;
		A.prev = v;
		A.next = C;
		A.prevYear = ba;
		A.nextYear = W;
		A.today = w;
		A.gotoDate = p;
		A.incrementDate = I;
		A.formatDate = function(l, s) {
			return Pa(l, s, b)
		};
		A.formatDates = function(l, s, da) {
			return lb(l, s, da, b)
		};
		A.getDate = Y;
		A.getView = ca;
		A.option = e;
		A.trigger = M;
		bc.call(A, b, g);
		var ha = A.isFetchNeeded,
			E = A.fetchEvents,
			ma = a[0],
			y, Q, H, P, i, F = {}, ga, fa, ya, j = 0,
			m = 0,
			t = new Date,
			X = [],
			z;
		Cb(t, b.year, b.month, b.date);
		b.droppable && o(document).bind("dragstart", function(l, s) {
			var da = l.target,
				pa = o(da);
			if (!pa.parents(".fc").length) {
				var ra = b.dropAccept;
				if (o.isFunction(ra) ? ra.call(da, pa) : pa.is(ra)) {
					z = da;
					i.dragStart(z, l, s)
				}
			}
		}).bind("dragstop", function(l, s) {
			if (z) {
				i.dragStop(z, l, s);
				z = null
			}
		})
	}
	function ac(a, b) {
		function g() {
			R = b.theme ? "ui" : "fc";
			if (b.header) return L = o("<table class='fc-header' style='width:100%'/>").append(o("<tr/>").append(f("left")).append(f("center")).append(f("right")))
		}

		function c() {
			L.remove()
		}
		function f(u) {
			var B = o("<td class='fc-header-" + u + "'/>");
			(u = b.header[u]) && o.each(u.split(" "), function(la) {
				la > 0 && B.append("<span class='fc-header-space'/>");
				var ea;
				o.each(this.split(","), function(na, T) {
					if (T == "title") {
						B.append("<span class='fc-header-title'><h2>&nbsp;</h2></span>");
						ea && ea.addClass(R + "-corner-right");
						ea = null
					} else {
						var N;
						if (a[T]) N = a[T];
						else if (Ha[T]) N = function() {
							aa.removeClass(R + "-state-hover");
							a.changeView(T)
						};
						if (N) {
							na = b.theme ? mb(b.buttonIcons, T) : null;
							var V = mb(b.buttonText,
							T),
								aa = o("<span class='fc-button " + (R == "ui" ? "ui-button" : "") + " fc-button-" + T + " " + R + "-state-default'><span class='fc-button-inner'><span class='fc-button-content'>" + (na ? "<span class='fc-icon-wrap'><span class='ui-icon ui-icon-" + na + "'/></span>" : V) + "</span><span class='fc-button-effect'><span></span></span></span></span>");
							if (aa) {
								aa.click(function() {
									aa.hasClass(R + "-state-disabled") || N()
								}).mousedown(function() {
									aa.not("." + R + "-state-active").not("." + R + "-state-disabled").addClass(R + "-state-down")
								}).mouseup(function() {
									aa.removeClass(R +
										"-state-down")
								}).hover(function() {
									aa.not("." + R + "-state-active").not("." + R + "-state-disabled").addClass(R + "-state-hover")
								}, function() {
									aa.removeClass(R + "-state-hover").removeClass(R + "-state-down")
								}).appendTo(B);
								ea || aa.addClass(R + "-corner-left");
								ea = aa
							}
						}
					}
				});
				ea && ea.addClass(R + "-corner-right")
			});
			return B
		}
		function k(u) {
			L.find("h2").html(u)
		}
		function q(u) {
			L.find("span.fc-button-" + u).addClass(R + "-state-active")
		}
		function h(u) {
			L.find("span.fc-button-" + u).removeClass(R + "-state-active")
		}
		function d(u) {
			L.find("span.fc-button-" + u).addClass(R + "-state-disabled")
		}
		function r(u) {
			L.find("span.fc-button-" + u).removeClass(R + "-state-disabled")
		}
		var O = this;
		O.render = g;
		O.destroy = c;
		O.updateTitle = k;
		O.activateButton = q;
		O.deactivateButton = h;
		O.disableButton = d;
		O.enableButton = r;
		var L = o([]),
			R
	}
	function bc(a, b) {
		function g(e, M) {
			return !C || e < C || M > ba
		}
		function c(e, M, A) {
			C = e;
			ba = M;
			W = e.getTimezoneOffset() * 60 * 1E3;
			w = M.getTimezoneOffset() * 60 * 1E3;
			ca = typeof A != "undefined" ? o.grep(ca, function(E) {
				return !na(E.source, A)
			}) : [];
			e = ++p;
			M = v.length;
			I = typeof A == "undefined" ? M : 1;
			for (var ha = 0; ha < M; ha++) if (typeof A == "undefined" || na(v[ha], A)) f(v[ha], e)
		}
		function f(e, M) {
			k(e, function(A) {
				if (M == p) {
					if (A) {
						for (var ha = 0; ha < A.length; ha++) {
							A[ha].source = e;
							la(A[ha])
						}
						ca = ca.concat(A)
					}
					I--;
					I || Z(ca)
				}
			})
		}
		function k(e, M) {
			var A, ha = Aa.sourceFetchers,
				E;
			for (A = 0; A < ha.length; A++) {
				E = ha[A](e, C, ba, M);
				if (E === true) return;
				else if (typeof E == "object") {
					k(E, M);
					return
				}
			}
			if (A = e.events) if (o.isFunction(A)) {
				u();
				A(G(C), G(ba), function(P) {
					M(P);
					B()
				})
			} else o.isArray(A) ? M(A) : M();
			else if (e.url) {
				var ma = e.success,
					y = e.error,
					Q = e.complete;
				A = o.extend({}, e.data || {});
				E = Va(e.startParam, a.startParam);
				ha = Va(e.endParam, a.endParam);
				if (E) {
					var H = C;
					if (e.startParamUTC) H -= W;
					A[E] = Math.round(+H / 1E3)
				}
				if (ha) {
					E = ba;
					if (e.endParamUTC) E -= w;
					A[ha] = Math.round(+E / 1E3)
				}
				u();
				o.ajax(o.extend({}, cc, e, {
					data: A,
					success: function(P) {
						P = P || [];
						var i = bb(ma, this, arguments);
						if (o.isArray(i)) P = i;
						M(P)
					},
					error: function() {
						bb(y, this, arguments);
						M()
					},
					complete: function() {
						bb(Q, this, arguments);
						B()
					}
				}))
			} else M()
		}
		function q(e) {
			if (e = h(e)) {
				I++;
				f(e, p)
			}
		}
		function h(e) {
			if (o.isFunction(e) || o.isArray(e)) e = {
				events: e
			};
			else if (typeof e == "string") e = {
				url: e
			};
			if (typeof e == "object") {
				ea(e);
				v.push(e);
				return e
			}
		}
		function d(e) {
			v = o.grep(v, function(M) {
				return !na(M, e)
			});
			ca = o.grep(ca, function(M) {
				return !na(M.source, e)
			});
			Z(ca)
		}
		function r(e) {
			var M, A = ca.length,
				ha, E = aa().defaultEventEnd,
				ma = e.start - e._start,
				y = e.end ? e.end - (e._end || E(e)) : 0;
			for (M = 0; M < A; M++) {
				ha = ca[M];
				if (ha._id == e._id && ha != e) {
					ha.start = new Date(+ha.start + ma);
					ha.end = e.end ? ha.end ? new Date(+ha.end + y) : new Date(+E(ha) + y) : null;
					ha.title = e.title;
					ha.url = e.url;
					ha.allDay = e.allDay;
					ha.className = e.className;
					ha.editable = e.editable;
					ha.color = e.color;
					ha.backgroudColor = e.backgroudColor;
					ha.borderColor = e.borderColor;
					ha.textColor = e.textColor;
					la(ha)
				}
			}
			la(e);
			Z(ca)
		}
		function O(e, M) {
			la(e);
			if (!e.source) if (M) {
				ja.events.push(e);
				e.source = ja
			}
			ca.push(e);
			Z(ca)
		}
		function L(e) {
			if (e) {
				if (!o.isFunction(e)) {
					var M = e + "";
					e = function(ha) {
						return ha._id == M
					}
				}
				ca = o.grep(ca, e, true);
				for (A = 0; A < v.length; A++) if (o.isArray(v[A].events)) v[A].events = o.grep(v[A].events, e, true)
			} else {
				ca = [];
				for (var A = 0; A < v.length; A++) if (o.isArray(v[A].events)) v[A].events = []
			}
			Z(ca)
		}
		function R(e) {
			if (o.isFunction(e)) return o.grep(ca, e);
			else if (e) {
				e += "";
				return o.grep(ca, function(M) {
					return M._id == e
				})
			}
			return ca
		}
		function u() {
			Y++ || V("loading", null, true)
		}
		function B() {
			--Y || V("loading", null, false)
		}
		function la(e) {
			var M = e.source || {}, A = Va(M.ignoreTimezone, a.ignoreTimezone);
			e._id = e._id || (e.id === sa ? "_fc" + dc++ : e.id + "");
			if (e.date) {
				if (!e.start) e.start = e.date;
				delete e.date
			}
			e._start = G(e.start = nb(e.start, A));
			e.end = nb(e.end, A);
			if (e.end && e.end <= e.start) e.end = null;
			e._end = e.end ? G(e.end) : null;
			if (e.allDay === sa) e.allDay = Va(M.allDayDefault, a.allDayDefault);
			if (e.className) {
				if (typeof e.className == "string") e.className = e.className.split(/\s+/)
			} else e.className = []
		}
		function ea(e) {
			if (e.className) {
				if (typeof e.className == "string") e.className = e.className.split(/\s+/)
			} else e.className = [];
			for (var M = Aa.sourceNormalizers, A = 0; A < M.length; A++) M[A](e)
		}
		function na(e, M) {
			return e && M && T(e) == T(M)
		}
		function T(e) {
			return (typeof e == "object" ? e.events || e.url : "") || e
		}
		var N = this;
		N.isFetchNeeded = g;
		N.fetchEvents = c;
		N.addEventSource = q;
		N.removeEventSource = d;
		N.updateEvent = r;
		N.renderEvent = O;
		N.removeEvents = L;
		N.clientEvents = R;
		N.normalizeEvent = la;
		var V = N.trigger,
			aa = N.getView,
			Z = N.reportEvents,
			ja = {
				events: []
			}, v = [ja],
			C, ba, W, w, p = 0,
			I = 0,
			Y = 0,
			ca = [];
		for (N = 0; N < b.length; N++) h(b[N])
	}
	function jb(a, b, g) {
		a.setFullYear(a.getFullYear() + b);
		g || Ia(a);
		return a
	}
	function kb(a, b, g) {
		if (+a) {
			b = a.getMonth() + b;
			var c = G(a);
			c.setDate(1);
			c.setMonth(b);
			a.setMonth(b);
			for (g || Ia(a); a.getMonth() != c.getMonth();) a.setDate(a.getDate() + (a < c ? 1 : -1))
		}
		return a
	}
	function ka(a, b, g) {
		if (+a) {
			b = a.getDate() + b;
			var c = G(a);
			c.setHours(9);
			c.setDate(b);
			a.setDate(b);
			g || Ia(a);
			ob(a, c)
		}
		return a
	}
	function ob(a, b) {
		if (+a) for (; a.getDate() != b.getDate();) a.setTime(+a + (a < b ? 1 : -1) * ec)
	}
	function xa(a, b) {
		a.setMinutes(a.getMinutes() + b);
		return a
	}
	function Ia(a) {
		a.setHours(0);
		a.setMinutes(0);
		a.setSeconds(0);
		a.setMilliseconds(0);
		return a
	}
	function G(a, b) {
		if (b) return Ia(new Date(+a));
		return new Date(+a)
	}
	function Db() {
		var a = 0,
			b;
		do b = new Date(1970, a++, 1);
		while (b.getHours());
		return b
	}
	function Ja(a, b, g) {
		for (b = b || 1; !a.getDay() || g && a.getDay() == 1 || !g && a.getDay() == 6;) ka(a, b);
		return a
	}
	function Ba(a, b) {
		return Math.round((G(a, true) - G(b, true)) / Qa)
	}
	function Cb(a, b, g, c) {
		if (b !== sa && b != a.getFullYear()) {
			a.setDate(1);
			a.setMonth(0);
			a.setFullYear(b)
		}
		if (g !== sa && g != a.getMonth()) {
			a.setDate(1);
			a.setMonth(g)
		}
		c !== sa && a.setDate(c)
	}
	function nb(a, b) {
		if (typeof a == "object") return a;
		if (typeof a == "number") return new Date(a * 1E3);
		if (typeof a == "string") {
			if (a.match(/^\d+(\.\d+)?$/)) return new Date(parseFloat(a) * 1E3);
			if (b === sa) b = true;
			return Eb(a, b) || (a ? new Date(a) : null)
		}
		return null
	}
	function Eb(a, b) {
		a = a.match(/^([0-9]{4})(-([0-9]{2})(-([0-9]{2})([T ]([0-9]{2}):([0-9]{2})(:([0-9]{2})(\.([0-9]+))?)?(Z|(([-+])([0-9]{2})(:?([0-9]{2}))?))?)?)?)?$/);
		if (!a) return null;
		var g = new Date(a[1], 0, 1);
		if (b || !a[13]) {
			b = new Date(a[1], 0, 1, 9, 0);
			if (a[3]) {
				g.setMonth(a[3] - 1);
				b.setMonth(a[3] - 1)
			}
			if (a[5]) {
				g.setDate(a[5]);
				b.setDate(a[5])
			}
			ob(g, b);
			a[7] && g.setHours(a[7]);
			a[8] && g.setMinutes(a[8]);
			a[10] && g.setSeconds(a[10]);
			a[12] && g.setMilliseconds(Number("0." + a[12]) * 1E3);
			ob(g, b)
		} else {
			g.setUTCFullYear(a[1], a[3] ? a[3] - 1 : 0, a[5] || 1);
			g.setUTCHours(a[7] || 0, a[8] || 0, a[10] || 0, a[12] ? Number("0." + a[12]) * 1E3 : 0);
			if (a[14]) {
				b = Number(a[16]) * 60 + (a[18] ? Number(a[18]) : 0);
				b *= a[15] == "-" ? 1 : -1;
				g = new Date(+g + b * 60 * 1E3)
			}
		}
		return g
	}
	function pb(a) {
		if (typeof a == "number") return a * 60;
		if (typeof a == "object") return a.getHours() * 60 + a.getMinutes();
		if (a = a.match(/(\d+)(?::(\d+))?\s*(\w+)?/)) {
			var b = parseInt(a[1], 10);
			if (a[3]) {
				b %= 12;
				if (a[3].toLowerCase().charAt(0) == "p") b += 12
			}
			return b * 60 + (a[2] ? parseInt(a[2],
			10) : 0)
		}
	}
	function Pa(a, b, g) {
		return lb(a, null, b, g)
	}
	function lb(a, b, g, c) {
		c = c || $a;
		var f = a,
			k = b,
			q, h = g.length,
			d, r, O, L = "";
		for (q = 0; q < h; q++) {
			d = g.charAt(q);
			if (d == "'") for (r = q + 1; r < h; r++) {
				if (g.charAt(r) == "'") {
					if (f) {
						L += r == q + 1 ? "'" : g.substring(q + 1, r);
						q = r
					}
					break
				}
			} else if (d == "(") for (r = q + 1; r < h; r++) {
				if (g.charAt(r) == ")") {
					q = Pa(f, g.substring(q + 1, r), c);
					if (parseInt(q.replace(/\D/, ""), 10)) L += q;
					q = r;
					break
				}
			} else if (d == "[") for (r = q + 1; r < h; r++) {
				if (g.charAt(r) == "]") {
					d = g.substring(q + 1, r);
					q = Pa(f, d, c);
					if (q != Pa(k, d, c)) L += q;
					q = r;
					break
				}
			} else if (d ==
				"{") {
				f = b;
				k = a
			} else if (d == "}") {
				f = a;
				k = b
			} else {
				for (r = h; r > q; r--) if (O = fc[g.substring(q, r)]) {
					if (f) L += O(f, c);
					q = r - 1;
					break
				}
				if (r == q) if (f) L += d
			}
		}
		return L
	}
	function Wa(a) {
		return a.end ? gc(a.end, a.allDay) : ka(G(a.start), 1)
	}
	function gc(a, b) {
		a = G(a);
		return b || a.getHours() || a.getMinutes() ? ka(a, 1) : Ia(a)
	}
	function hc(a, b) {
		return (b.msLength - a.msLength) * 100 + (a.event.start - b.event.start)
	}
	function Fb(a, b) {
		return a.end > b.start && a.start < b.end
	}
	function qb(a, b, g, c) {
		var f = [],
			k, q = a.length,
			h, d, r, O, L;
		for (k = 0; k < q; k++) {
			h = a[k];
			d = h.start;
			r = b[k];
			if (r > g && d < c) {
				if (d < g) {
					d = G(g);
					O = false
				} else {
					d = d;
					O = true
				}
				if (r > c) {
					r = G(c);
					L = false
				} else {
					r = r;
					L = true
				}
				f.push({
					event: h,
					start: d,
					end: r,
					isStart: O,
					isEnd: L,
					msLength: r - d
				})
			}
		}
		return f.sort(hc)
	}
	function rb(a) {
		var b = [],
			g, c = a.length,
			f, k, q, h;
		for (g = 0; g < c; g++) {
			f = a[g];
			for (k = 0;;) {
				q = false;
				if (b[k]) for (h = 0; h < b[k].length; h++) if (Fb(b[k][h], f)) {
					q = true;
					break
				}
				if (q) k++;
				else break
			}
			if (b[k]) b[k].push(f);
			else b[k] = [f]
		}
		return b
	}
	function Gb(a, b, g) {
		a.unbind("mouseover").mouseover(function(c) {
			for (var f = c.target, k; f != this;) {
				k = f;
				f = f.parentNode
			}
			if ((f = k._fci) !== sa) {
				k._fci = sa;
				k = b[f];
				g(k.event, k.element, k);
				o(c.target).trigger(c)
			}
			c.stopPropagation()
		})
	}
	function Xa(a, b, g) {
		for (var c = 0, f; c < a.length; c++) {
			f = o(a[c]);
			f.width(Math.max(0, b - sb(f, g)))
		}
	}
	function Hb(a, b, g) {
		for (var c = 0, f; c < a.length; c++) {
			f = o(a[c]);
			f.height(Math.max(0, b - Ua(f, g)))
		}
	}
	function sb(a, b) {
		return ic(a) + jc(a) + (b ? kc(a) : 0)
	}
	function ic(a) {
		return (parseFloat(o.curCSS(a[0], "paddingLeft", true)) || 0) + (parseFloat(o.curCSS(a[0], "paddingRight", true)) || 0)
	}
	function kc(a) {
		return (parseFloat(o.curCSS(a[0],
			"marginLeft", true)) || 0) + (parseFloat(o.curCSS(a[0], "marginRight", true)) || 0)
	}
	function jc(a) {
		return (parseFloat(o.curCSS(a[0], "borderLeftWidth", true)) || 0) + (parseFloat(o.curCSS(a[0], "borderRightWidth", true)) || 0)
	}
	function Ua(a, b) {
		return lc(a) + mc(a) + (b ? Ib(a) : 0)
	}
	function lc(a) {
		return (parseFloat(o.curCSS(a[0], "paddingTop", true)) || 0) + (parseFloat(o.curCSS(a[0], "paddingBottom", true)) || 0)
	}
	function Ib(a) {
		return (parseFloat(o.curCSS(a[0], "marginTop", true)) || 0) + (parseFloat(o.curCSS(a[0], "marginBottom", true)) || 0)
	}

	function mc(a) {
		return (parseFloat(o.curCSS(a[0], "borderTopWidth", true)) || 0) + (parseFloat(o.curCSS(a[0], "borderBottomWidth", true)) || 0)
	}
	function ab(a, b) {
		b = typeof b == "number" ? b + "px" : b;
		a.each(function(g, c) {
			c.style.cssText += ";min-height:" + b + ";_height:" + b
		})
	}
	function Bb() {}
	function Jb(a, b) {
		return a - b
	}
	function Kb(a) {
		return Math.max.apply(Math, a)
	}
	function Ra(a) {
		return (a < 10 ? "0" : "") + a
	}
	function mb(a, b) {
		if (a[b] !== sa) return a[b];
		b = b.split(/(?=[A-Z])/);
		for (var g = b.length - 1, c; g >= 0; g--) {
			c = a[b[g].toLowerCase()];
			if (c !== sa) return c
		}
		return a[""]
	}
	function Ea(a) {
		return a.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&#039;").replace(/"/g, "&quot;").replace(/\n/g, "<br />")
	}
	function Lb(a) {
		return a.id + "/" + a.className + "/" + a.style.cssText.replace(/(^|;)\s*(top|left|width|height)\s*:[^;]*/ig, "")
	}
	function tb(a) {
		a.attr("unselectable", "on").css("MozUserSelect", "none").bind("selectstart.ui", function() {
			return false
		})
	}
	function Sa(a) {
		a.children().removeClass("fc-first fc-last").filter(":first-child").addClass("fc-first").end().filter(":last-child").addClass("fc-last")
	}

	function ub(a, b) {
		a.each(function(g, c) {
			c.className = c.className.replace(/^fc-\w*/, "fc-" + Mb[b.getDay()])
		})
	}
	function cb(a, b) {
		var g = a.source || {}, c = a.color,
			f = g.color,
			k = b("eventColor"),
			q = a.backgroundColor || c || g.backgroundColor || f || b("eventBackgroundColor") || k;
		c = a.borderColor || c || g.borderColor || f || b("eventBorderColor") || k;
		a = a.textColor || g.textColor || b("eventTextColor");
		b = [];
		q && b.push("background-color:" + q);
		c && b.push("border-color:" + c);
		a && b.push("color:" + a);
		return b.join(";")
	}
	function bb(a, b, g) {
		if (o.isFunction(a)) a = [a];
		if (a) {
			var c, f;
			for (c = 0; c < a.length; c++) f = a[c].apply(b, g) || f;
			return f
		}
	}
	function Va() {
		for (var a = 0; a < arguments.length; a++) if (arguments[a] !== sa) return arguments[a]
	}
	function nc(a, b) {
		function g(h, d) {
			if (d) {
				kb(h, d);
				h.setDate(1)
			}
			h = G(h, true);
			h.setDate(1);
			d = kb(G(h), 1);
			var r = G(h),
				O = G(d),
				L = f("firstDay"),
				R = f("weekends") ? 0 : 1;
			if (R) {
				Ja(r);
				Ja(O, -1, true)
			}
			ka(r, -((r.getDay() - Math.max(L, R) + 7) % 7));
			ka(O, (7 - O.getDay() + Math.max(L, R)) % 7);
			L = Math.round((O - r) / (Qa * 7));
			if (f("weekMode") == "fixed") {
				ka(O, (6 - L) * 7);
				L = 6
			}
			c.title = q(h,
			f("titleFormat"));
			c.start = h;
			c.end = d;
			c.visStart = r;
			c.visEnd = O;
			k(6, L, R ? 5 : 7, true)
		}
		var c = this;
		c.render = g;
		vb.call(c, a, b, "month");
		var f = c.opt,
			k = c.renderBasic,
			q = b.formatDate
	}
	function oc(a, b) {
		function g(h, d) {
			d && ka(h, d * 7);
			h = ka(G(h), -((h.getDay() - f("firstDay") + 7) % 7));
			d = ka(G(h), 7);
			var r = G(h),
				O = G(d),
				L = f("weekends");
			if (!L) {
				Ja(r);
				Ja(O, -1, true)
			}
			c.title = q(r, ka(G(O), -1), f("titleFormat"));
			c.start = h;
			c.end = d;
			c.visStart = r;
			c.visEnd = O;
			k(1, 1, L ? 7 : 5, false)
		}
		var c = this;
		c.render = g;
		vb.call(c, a, b, "basicWeek");
		var f = c.opt,
			k = c.renderBasic,
			q = b.formatDates
	}
	function pc(a, b) {
		function g(h, d) {
			if (d) {
				ka(h, d);
				f("weekends") || Ja(h, d < 0 ? -1 : 1)
			}
			c.title = q(h, f("titleFormat"));
			c.start = c.visStart = G(h, true);
			c.end = c.visEnd = ka(G(c.start), 1);
			k(1, 1, 1, false)
		}
		var c = this;
		c.render = g;
		vb.call(c, a, b, "basicDay");
		var f = c.opt,
			k = c.renderBasic,
			q = b.formatDate
	}
	function vb(a, b, g) {
		function c(x, J, $, S) {
			j = J;
			m = $;
			f();
			(J = !y) ? k(x, S) : ca();
			q(J)
		}
		function f() {
			if (l = I("isRTL")) {
				s = -1;
				da = m - 1
			} else {
				s = 1;
				da = 0
			}
			pa = I("firstDay");
			ra = I("weekends") ? 0 : 1;
			qa = I("theme") ? "ui" : "fc";
			ua = I("columnFormat")
		}

		function k(x, J) {
			var $, S = qa + "-widget-header",
				oa = qa + "-widget-content",
				ia;
			$ = "<table class='fc-border-separate' style='width:100%' cellspacing='0'><thead><tr>";
			for (ia = 0; ia < m; ia++) $ += "<th class='fc- " + S + "'/>";
			$ += "</tr></thead><tbody>";
			for (ia = 0; ia < x; ia++) {
				$ += "<tr class='fc-week" + ia + "'>";
				for (S = 0; S < m; S++) $ += "<td class='fc- " + oa + " fc-day" + (ia * m + S) + "'><div>" + (J ? "<div class='fc-day-number'/>" : "") + "<div class='fc-day-content'><div style='position:relative'>&nbsp;</div></div></div></td>";
				$ += "</tr>"
			}
			$ += "</tbody></table>";
			x = o($).appendTo(a);
			E = x.find("thead");
			ma = E.find("th");
			y = x.find("tbody");
			Q = y.find("tr");
			H = y.find("td");
			P = H.filter(":first-child");
			i = Q.eq(0).find("div.fc-day-content div");
			Sa(E.add(E.find("tr")));
			Sa(Q);
			Q.eq(0).addClass("fc-first");
			r(H);
			F = o("<div style='position:absolute;z-index:8;top:0;left:0'/>").appendTo(a)
		}
		function q(x) {
			var J = x || j == 1,
				$ = p.start.getMonth(),
				S = Ia(new Date),
				oa, ia, va;
			J && ma.each(function(wa, Ca) {
				oa = o(Ca);
				ia = C(wa);
				oa.html(ha(ia, ua));
				ub(oa, ia)
			});
			H.each(function(wa, Ca) {
				oa = o(Ca);
				ia = C(wa);
				ia.getMonth() == $ ? oa.removeClass("fc-other-month") : oa.addClass("fc-other-month"); + ia == +S ? oa.addClass(qa + "-state-highlight fc-today") : oa.removeClass(qa + "-state-highlight fc-today");
				oa.find("div.fc-day-number").text(ia.getDate());
				J && ub(oa, ia)
			});
			Q.each(function(wa, Ca) {
				va = o(Ca);
				if (wa < j) {
					va.show();
					wa == j - 1 ? va.addClass("fc-last") : va.removeClass("fc-last")
				} else va.hide()
			})
		}
		function h(x) {
			fa = x;
			x = fa - E.height();
			var J, $, S;
			if (I("weekMode") == "variable") J = $ = Math.floor(x / (j == 1 ? 2 : 6));
			else {
				J = Math.floor(x / j);
				$ = x - J * (j - 1)
			}
			P.each(function(oa,
			ia) {
				if (oa < j) {
					S = o(ia);
					ab(S.find("> div"), (oa == j - 1 ? $ : J) - Ua(S))
				}
			})
		}
		function d(x) {
			ga = x;
			z.clear();
			ya = Math.floor(ga / m);
			Xa(ma.slice(0, -1), ya)
		}
		function r(x) {
			x.click(O).mousedown(A)
		}
		function O(x) {
			if (!I("selectable")) {
				var J = parseInt(this.className.match(/fc\-day(\d+)/)[1]);
				J = C(J);
				Y("dayClick", this, J, true, x)
			}
		}
		function L(x, J, $) {
			$ && t.build();
			$ = G(p.visStart);
			for (var S = ka(G($), m), oa = 0; oa < j; oa++) {
				var ia = new Date(Math.max($, x)),
					va = new Date(Math.min(S, J));
				if (ia < va) {
					var wa;
					if (l) {
						wa = Ba(va, $) * s + da + 1;
						ia = Ba(ia, $) * s + da + 1
					} else {
						wa = Ba(ia, $);
						ia = Ba(va, $)
					}
					r(R(oa, wa, oa, ia - 1))
				}
				ka($, 7);
				ka(S, 7)
			}
		}
		function R(x, J, $, S) {
			x = t.rect(x, J, $, S, a);
			return e(x, a)
		}
		function u(x) {
			return G(x)
		}
		function B(x, J) {
			L(x, ka(G(J), 1), true)
		}
		function la() {
			M()
		}
		function ea(x, J, $) {
			var S = Z(x);
			Y("dayClick", H[S.row * m + S.col], x, J, $)
		}
		function na(x, J) {
			X.start(function($) {
				M();
				$ && R($.row, $.col, $.row, $.col)
			}, J)
		}
		function T(x, J, $) {
			var S = X.stop();
			M();
			if (S) {
				S = ja(S);
				Y("drop", x, S, true, J, $)
			}
		}
		function N(x) {
			return G(x.start)
		}
		function V(x) {
			return z.left(x)
		}
		function aa(x) {
			return z.right(x)
		}

		function Z(x) {
			return {
				row: Math.floor(Ba(x, p.visStart) / 7),
				col: ba(x.getDay())
			}
		}
		function ja(x) {
			return v(x.row, x.col)
		}
		function v(x, J) {
			return ka(G(p.visStart), x * 7 + J * s + da)
		}
		function C(x) {
			return v(Math.floor(x / m), x % m)
		}
		function ba(x) {
			return (x - Math.max(pa, ra) + m) % m * s + da
		}
		function W(x) {
			return Q.eq(x)
		}
		function w() {
			return {
				left: 0,
				right: ga
			}
		}
		var p = this;
		p.renderBasic = c;
		p.setHeight = h;
		p.setWidth = d;
		p.renderDayOverlay = L;
		p.defaultSelectionEnd = u;
		p.renderSelection = B;
		p.clearSelection = la;
		p.reportDayClick = ea;
		p.dragStart = na;
		p.dragStop = T;
		p.defaultEventEnd = N;
		p.getHoverListener = function() {
			return X
		};
		p.colContentLeft = V;
		p.colContentRight = aa;
		p.dayOfWeekCol = ba;
		p.dateCell = Z;
		p.cellDate = ja;
		p.cellIsAllDay = function() {
			return true
		};
		p.allDayRow = W;
		p.allDayBounds = w;
		p.getRowCnt = function() {
			return j
		};
		p.getColCnt = function() {
			return m
		};
		p.getColWidth = function() {
			return ya
		};
		p.getDaySegmentContainer = function() {
			return F
		};
		db.call(p, a, b, g);
		Nb.call(p);
		Ob.call(p);
		qc.call(p);
		var I = p.opt,
			Y = p.trigger,
			ca = p.clearEvents,
			e = p.renderOverlay,
			M = p.clearOverlays,
			A = p.daySelectionMousedown,
			ha = b.formatDate,
			E, ma, y, Q, H, P, i, F, ga, fa, ya, j, m, t, X, z, l, s, da, pa, ra, qa, ua;
		tb(a.addClass("fc-grid"));
		t = new Pb(function(x, J) {
			var $, S, oa;
			ma.each(function(ia, va) {
				$ = o(va);
				S = $.offset().left;
				if (ia) oa[1] = S;
				oa = [S];
				J[ia] = oa
			});
			oa[1] = S + $.outerWidth();
			Q.each(function(ia, va) {
				if (ia < j) {
					$ = o(va);
					S = $.offset().top;
					if (ia) oa[1] = S;
					oa = [S];
					x[ia] = oa
				}
			});
			oa[1] = S + $.outerHeight()
		});
		X = new Qb(t);
		z = new Rb(function(x) {
			return i.eq(x)
		})
	}
	function qc() {
		function a(v, C) {
			O(v);
			Z(g(v), C)
		}
		function b() {
			L();
			ea().empty()
		}
		function g(v) {
			var C = V(),
				ba = aa(),
				W = G(k.visStart);
			ba = ka(G(W), ba);
			var w = o.map(v, Wa),
				p, I, Y, ca, e, M, A = [];
			for (p = 0; p < C; p++) {
				I = rb(qb(v, w, W, ba));
				for (Y = 0; Y < I.length; Y++) {
					ca = I[Y];
					for (e = 0; e < ca.length; e++) {
						M = ca[e];
						M.row = p;
						M.level = Y;
						A.push(M)
					}
				}
				ka(W, 7);
				ka(ba, 7)
			}
			return A
		}
		function c(v, C, ba) {
			d(v) && f(v, C);
			ba.isEnd && r(v) && ja(v, C, ba);
			R(v, C)
		}
		function f(v, C) {
			var ba = na(),
				W;
			C.draggable({
				zIndex: 9,
				delay: 50,
				opacity: q("dragOpacity"),
				revertDuration: q("dragRevertDuration"),
				start: function(w, p) {
					h("eventDragStart", C, v, w, p);
					B(v, C);
					ba.start(function(I, Y, ca,
					e) {
						C.draggable("option", "revert", !I || !ca && !e);
						N();
						if (I) {
							W = ca * 7 + e * (q("isRTL") ? -1 : 1);
							T(ka(G(v.start), W), ka(Wa(v), W))
						} else W = 0
					}, w, "drag")
				},
				stop: function(w, p) {
					ba.stop();
					N();
					h("eventDragStop", C, v, w, p);
					if (W) la(this, v, W, 0, v.allDay, w, p);
					else {
						C.css("filter", "");
						u(v, C)
					}
				}
			})
		}
		var k = this;
		k.renderEvents = a;
		k.compileDaySegs = g;
		k.clearEvents = b;
		k.bindDaySeg = c;
		wb.call(k);
		var q = k.opt,
			h = k.trigger,
			d = k.isEventDraggable,
			r = k.isEventResizable,
			O = k.reportEvents,
			L = k.reportEventClear,
			R = k.eventElementHandlers,
			u = k.showEvents,
			B = k.hideEvents,
			la = k.eventDrop,
			ea = k.getDaySegmentContainer,
			na = k.getHoverListener,
			T = k.renderDayOverlay,
			N = k.clearOverlays,
			V = k.getRowCnt,
			aa = k.getColCnt,
			Z = k.renderDaySegs,
			ja = k.resizableDayEvent
	}
	function rc(a, b) {
		function g(h, d) {
			d && ka(h, d * 7);
			h = ka(G(h), -((h.getDay() - f("firstDay") + 7) % 7));
			d = ka(G(h), 7);
			var r = G(h),
				O = G(d),
				L = f("weekends");
			if (!L) {
				Ja(r);
				Ja(O, -1, true)
			}
			c.title = q(r, ka(G(O), -1), f("titleFormat"));
			c.start = h;
			c.end = d;
			c.visStart = r;
			c.visEnd = O;
			k(L ? 7 : 5)
		}
		var c = this;
		c.render = g;
		Sb.call(c, a, b, "agendaWeek");
		var f = c.opt,
			k = c.renderAgenda,
			q = b.formatDates
	}
	function sc(a, b) {
		function g(h, d) {
			if (d) {
				ka(h, d);
				f("weekends") || Ja(h, d < 0 ? -1 : 1)
			}
			d = G(h, true);
			var r = ka(G(d), 1);
			c.title = q(h, f("titleFormat"));
			c.start = c.visStart = d;
			c.end = c.visEnd = r;
			k(1)
		}
		var c = this;
		c.render = g;
		Sb.call(c, a, b, "agendaDay");
		var f = c.opt,
			k = c.renderAgenda,
			q = b.formatDate
	}
	function Sb(a, b, g) {
		function c(n) {
			Da = n;
			f();
			j ? Q() : k();
			q()
		}
		function f() {
			Ya = ma("theme") ? "ui" : "fc";
			Tb = ma("weekends") ? 0 : 1;
			Ub = ma("firstDay");
			if (Vb = ma("isRTL")) {
				Ka = -1;
				La = Da - 1
			} else {
				Ka = 1;
				La = 0
			}
			Ma = pb(ma("minTime"));
			eb = pb(ma("maxTime"));
			Wb = ma("columnFormat")
		}
		function k() {
			var n = Ya + "-widget-header",
				U = Ya + "-widget-content",
				K, D, ta, za, Fa, Ga = ma("slotMinutes") % 15 == 0;
			K = "<table style='width:100%' class='fc-agenda-days fc-border-separate' cellspacing='0'><thead><tr><th class='fc-agenda-axis " + n + "'>&nbsp;</th>";
			for (D = 0; D < Da; D++) K += "<th class='fc- fc-col" + D + " " + n + "'/>";
			K += "<th class='fc-agenda-gutter " + n + "'>&nbsp;</th></tr></thead><tbody><tr><th class='fc-agenda-axis " + n + "'>&nbsp;</th>";
			for (D = 0; D < Da; D++) K += "<td class='fc- fc-col" + D + " " + U + "'><div><div class='fc-day-content'><div style='position:relative'>&nbsp;</div></div></div></td>";
			K += "<td class='fc-agenda-gutter " + U + "'>&nbsp;</td></tr></tbody></table>";
			j = o(K).appendTo(a);
			m = j.find("thead");
			t = m.find("th").slice(1, -1);
			X = j.find("tbody");
			z = X.find("td").slice(0, -1);
			l = z.find("div.fc-day-content div");
			s = z.eq(0);
			da = s.find("> div");
			Sa(m.add(m.find("tr")));
			Sa(X.add(X.find("tr")));
			ia = m.find("th:first");
			va = j.find(".fc-agenda-gutter");
			pa = o("<div style='position:absolute;z-index:2;left:0;width:100%'/>").appendTo(a);
			if (ma("allDaySlot")) {
				ra = o("<div style='position:absolute;z-index:8;top:0;left:0'/>").appendTo(pa);
				K = "<table style='width:100%' class='fc-agenda-allday' cellspacing='0'><tr><th class='" + n + " fc-agenda-axis'>" + ma("allDayText") + "</th><td><div class='fc-day-content'><div style='position:relative'/></div></td><th class='" + n + " fc-agenda-gutter'>&nbsp;</th></tr></table>";
				qa = o(K).appendTo(pa);
				ua = qa.find("tr");
				R(ua.find("td"));
				ia = ia.add(qa.find("th:first"));
				va = va.add(qa.find("th.fc-agenda-gutter"));
				pa.append("<div class='fc-agenda-divider " + n + "'><div class='fc-agenda-divider-inner'/></div>")
			} else ra = o([]);
			x = o("<div style='position:absolute;width:100%;overflow-x:hidden;overflow-y:auto'/>").appendTo(pa);
			J = o("<div style='position:relative;width:100%;overflow:hidden'/>").appendTo(x);
			$ = o("<div style='position:absolute;z-index:8;top:0;left:0'/>").appendTo(J);
			K = "<table class='fc-agenda-slots' style='width:100%' cellspacing='0'><tbody>";
			ta = Db();
			za = xa(G(ta), eb);
			xa(ta, Ma);
			for (D = xb = 0; ta < za; D++) {
				Fa = ta.getMinutes();
				K += "<tr class='fc-slot" + D + " " + (!Fa ? "" : "fc-minor") + "'><th class='fc-agenda-axis " + n + "'>" + (!Ga || !Fa ? ya(ta, ma("axisFormat")) : "&nbsp;") + "</th><td class='" + U + "'><div style='position:relative'>&nbsp;</div></td></tr>";
				xa(ta, ma("slotMinutes"));
				xb++
			}
			K += "</tbody></table>";
			S = o(K).appendTo(J);
			oa = S.find("div:first");
			u(S.find("td"));
			ia = ia.add(S.find("th:first"))
		}
		function q() {
			var n, U, K, D, ta = Ia(new Date);
			for (n = 0; n < Da; n++) {
				D = Z(n);
				U = t.eq(n);
				U.html(ya(D, Wb));
				K = z.eq(n); + D == +ta ? K.addClass(Ya + "-state-highlight fc-today") : K.removeClass(Ya + "-state-highlight fc-today");
				ub(U.add(K), D)
			}
		}
		function h(n, U) {
			if (n === sa) n = Xb;
			Xb = n;
			yb = {};
			var K = X.position().top,
				D = x.position().top;
			n = Math.min(n - K, S.height() + D + 1);
			da.height(n - Ua(s));
			pa.css("top", K);
			x.height(n - D - 1);
			Za = oa.height() + 1;
			U && r()
		}
		function d(n) {
			Ca = n;
			fb.clear();
			Na = 0;
			Xa(ia.width("").each(function(U, K) {
				Na = Math.max(Na, o(K).outerWidth())
			}), Na);
			n = x[0].clientWidth;
			if (zb = x.width() - n) {
				Xa(va, zb);
				va.show().prev().removeClass("fc-last")
			} else va.hide().prev().addClass("fc-last");
			gb = Math.floor((n - Na) / Da);
			Xa(t.slice(0, -1), gb)
		}
		function r() {
			function n() {
				x.scrollTop(D)
			}
			var U = Db(),
				K = G(U);
			K.setHours(ma("firstHour"));
			var D = C(U, K) + 1;
			n();
			setTimeout(n, 0)
		}
		function O() {
			Yb = x.scrollTop()
		}
		function L() {
			x.scrollTop(Yb)
		}
		function R(n) {
			n.click(B).mousedown(ga)
		}
		function u(n) {
			n.click(B).mousedown(e)
		}
		function B(n) {
			if (!ma("selectable")) {
				var U = Math.min(Da - 1, Math.floor((n.pageX - j.offset().left - Na) / gb)),
					K = Z(U),
					D = this.parentNode.className.match(/fc-slot(\d+)/);
				if (D) {
					D = parseInt(D[1]) * ma("slotMinutes");
					var ta = Math.floor(D / 60);
					K.setHours(ta);
					K.setMinutes(D % 60 + Ma);
					y("dayClick", z[U], K, false, n)
				} else y("dayClick",
				z[U], K, true, n)
			}
		}
		function la(n, U, K) {
			K && Oa.build();
			var D = G(E.visStart);
			if (Vb) {
				K = Ba(U, D) * Ka + La + 1;
				n = Ba(n, D) * Ka + La + 1
			} else {
				K = Ba(n, D);
				n = Ba(U, D)
			}
			K = Math.max(0, K);
			n = Math.min(Da, n);
			K < n && R(ea(0, K, 0, n - 1))
		}
		function ea(n, U, K, D) {
			n = Oa.rect(n, U, K, D, pa);
			return H(n, pa)
		}
		function na(n, U) {
			for (var K = G(E.visStart), D = ka(G(K), 1), ta = 0; ta < Da; ta++) {
				var za = new Date(Math.max(K, n)),
					Fa = new Date(Math.min(D, U));
				if (za < Fa) {
					var Ga = ta * Ka + La;
					Ga = Oa.rect(0, Ga, 0, Ga, J);
					za = C(K, za);
					Fa = C(K, Fa);
					Ga.top = za;
					Ga.height = Fa - za;
					u(H(Ga, J))
				}
				ka(K, 1);
				ka(D,
				1)
			}
		}
		function T(n) {
			return fb.left(n)
		}
		function N(n) {
			return fb.right(n)
		}
		function V(n) {
			return {
				row: Math.floor(Ba(n, E.visStart) / 7),
				col: v(n.getDay())
			}
		}
		function aa(n) {
			var U = Z(n.col);
			n = n.row;
			ma("allDaySlot") && n--;
			n >= 0 && xa(U, Ma + n * ma("slotMinutes"));
			return U
		}
		function Z(n) {
			return ka(G(E.visStart), n * Ka + La)
		}
		function ja(n) {
			return ma("allDaySlot") && !n.row
		}
		function v(n) {
			return (n - Math.max(Ub, Tb) + Da) % Da * Ka + La
		}
		function C(n, U) {
			n = G(n, true);
			if (U < xa(G(n), Ma)) return 0;
			if (U >= xa(G(n), eb)) return S.height();
			n = ma("slotMinutes");
			U = U.getHours() * 60 + U.getMinutes() - Ma;
			var K = Math.floor(U / n),
				D = yb[K];
			if (D === sa) D = yb[K] = S.find("tr:eq(" + K + ") td div")[0].offsetTop;
			return Math.max(0, Math.round(D - 1 + Za * (U % n / n)))
		}
		function ba() {
			return {
				left: Na,
				right: Ca - zb
			}
		}
		function W() {
			return ua
		}
		function w(n) {
			var U = G(n.start);
			if (n.allDay) return U;
			return xa(U, ma("defaultEventMinutes"))
		}
		function p(n, U) {
			if (U) return G(n);
			return xa(G(n), ma("slotMinutes"))
		}
		function I(n, U, K) {
			if (K) ma("allDaySlot") && la(n, ka(G(U), 1), true);
			else Y(n, U)
		}
		function Y(n, U) {
			var K = ma("selectHelper");
			Oa.build();
			if (K) {
				var D = Ba(n, E.visStart) * Ka + La;
				if (D >= 0 && D < Da) {
					D = Oa.rect(0, D, 0, D, J);
					var ta = C(n, n),
						za = C(n, U);
					if (za > ta) {
						D.top = ta;
						D.height = za - ta;
						D.left += 2;
						D.width -= 5;
						if (o.isFunction(K)) {
							if (n = K(n, U)) {
								D.position = "absolute";
								D.zIndex = 8;
								wa = o(n).css(D).appendTo(J)
							}
						} else {
							D.isStart = true;
							D.isEnd = true;
							wa = o(fa({
								title: "",
								start: n,
								end: U,
								className: ["fc-select-helper"],
								editable: false
							}, D));
							wa.css("opacity", ma("dragOpacity"))
						}
						if (wa) {
							u(wa);
							J.append(wa);
							Xa(wa, D.width, true);
							Hb(wa, D.height, true)
						}
					}
				}
			} else na(n, U)
		}
		function ca() {
			P();
			if (wa) {
				wa.remove();
				wa = null
			}
		}
		function e(n) {
			if (n.which == 1 && ma("selectable")) {
				F(n);
				var U, K = ma("selectHelper");
				Ta.start(function(D, ta) {
					ca();
					if (D && (D.col == ta.col || !K) && !ja(D)) {
						ta = aa(ta);
						D = aa(D);
						U = [ta, xa(G(ta), ma("slotMinutes")), D, xa(G(D), ma("slotMinutes"))].sort(Jb);
						Y(U[0], U[3])
					} else U = null
				}, n);
				o(document).one("mouseup", function(D) {
					Ta.stop();
					if (U) {
						+U[0] == +U[1] && M(U[0], false, D);
						i(U[0], U[3], false, D)
					}
				})
			}
		}
		function M(n, U, K) {
			y("dayClick", z[v(n.getDay())], n, U, K)
		}
		function A(n, U) {
			Ta.start(function(K) {
				P();
				if (K) if (ja(K)) ea(K.row,
				K.col, K.row, K.col);
				else {
					K = aa(K);
					var D = xa(G(K), ma("defaultEventMinutes"));
					na(K, D)
				}
			}, U)
		}
		function ha(n, U, K) {
			var D = Ta.stop();
			P();
			D && y("drop", n, aa(D), ja(D), U, K)
		}
		var E = this;
		E.renderAgenda = c;
		E.setWidth = d;
		E.setHeight = h;
		E.beforeHide = O;
		E.afterShow = L;
		E.defaultEventEnd = w;
		E.timePosition = C;
		E.dayOfWeekCol = v;
		E.dateCell = V;
		E.cellDate = aa;
		E.cellIsAllDay = ja;
		E.allDayRow = W;
		E.allDayBounds = ba;
		E.getHoverListener = function() {
			return Ta
		};
		E.colContentLeft = T;
		E.colContentRight = N;
		E.getDaySegmentContainer = function() {
			return ra
		};
		E.getSlotSegmentContainer = function() {
			return $
		};
		E.getMinMinute = function() {
			return Ma
		};
		E.getMaxMinute = function() {
			return eb
		};
		E.getBodyContent = function() {
			return J
		};
		E.getRowCnt = function() {
			return 1
		};
		E.getColCnt = function() {
			return Da
		};
		E.getColWidth = function() {
			return gb
		};
		E.getSlotHeight = function() {
			return Za
		};
		E.defaultSelectionEnd = p;
		E.renderDayOverlay = la;
		E.renderSelection = I;
		E.clearSelection = ca;
		E.reportDayClick = M;
		E.dragStart = A;
		E.dragStop = ha;
		db.call(E, a, b, g);
		Nb.call(E);
		Ob.call(E);
		tc.call(E);
		var ma = E.opt,
			y = E.trigger,
			Q = E.clearEvents,
			H = E.renderOverlay,
			P = E.clearOverlays,
			i = E.reportSelection,
			F = E.unselect,
			ga = E.daySelectionMousedown,
			fa = E.slotSegHtml,
			ya = b.formatDate,
			j, m, t, X, z, l, s, da, pa, ra, qa, ua, x, J, $, S, oa, ia, va, wa, Ca, Xb, Na, gb, zb, Za, Yb, Da, xb, Oa, Ta, fb, yb = {}, Ya, Ub, Tb, Vb, Ka, La, Ma, eb, Wb;
		tb(a.addClass("fc-agenda"));
		Oa = new Pb(function(n, U) {
			function K(hb) {
				return Math.max(Ga, Math.min(uc, hb))
			}
			var D, ta, za;
			t.each(function(hb, vc) {
				D = o(vc);
				ta = D.offset().left;
				if (hb) za[1] = ta;
				za = [ta];
				U[hb] = za
			});
			za[1] = ta + D.outerWidth();
			if (ma("allDaySlot")) {
				D = ua;
				ta = D.offset().top;
				n[0] = [ta, ta + D.outerHeight()]
			}
			for (var Fa = J.offset().top, Ga = x.offset().top, uc = Ga + x.outerHeight(), ib = 0; ib < xb; ib++) n.push([K(Fa + Za * ib), K(Fa + Za * (ib + 1))])
		});
		Ta = new Qb(Oa);
		fb = new Rb(function(n) {
			return l.eq(n)
		})
	}
	function tc() {
		function a(j, m) {
			N(j);
			var t, X = j.length,
				z = [],
				l = [];
			for (t = 0; t < X; t++) j[t].allDay ? z.push(j[t]) : l.push(j[t]);
			if (B("allDaySlot")) {
				Y(g(z), m);
				Z()
			}
			k(c(l), m);
			if (B("currentTimeIndicator")) {
				window.clearInterval(ya);
				ya = window.setInterval(r, 3E4);
				r()
			}
		}
		function b() {
			V();
			ja().empty();
			v().empty()
		}
		function g(j) {
			j = rb(qb(j, o.map(j, Wa), u.visStart, u.visEnd));
			var m, t = j.length,
				X, z, l, s = [];
			for (m = 0; m < t; m++) {
				X = j[m];
				for (z = 0; z < X.length; z++) {
					l = X[z];
					l.row = 0;
					l.level = m;
					s.push(l)
				}
			}
			return s
		}
		function c(j) {
			var m = e(),
				t = W(),
				X = ba(),
				z = xa(G(u.visStart), t),
				l = o.map(j, f),
				s, da, pa, ra, qa, ua, x = [];
			for (s = 0; s < m; s++) {
				da = rb(qb(j, l, z, xa(G(z), X - t)));
				wc(da);
				for (pa = 0; pa < da.length; pa++) {
					ra = da[pa];
					for (qa = 0; qa < ra.length; qa++) {
						ua = ra[qa];
						ua.col = s;
						ua.level = pa;
						x.push(ua)
					}
				}
				ka(z, 1, true)
			}
			return x
		}
		function f(j) {
			return j.end ? G(j.end) : xa(G(j.start), B("defaultEventMinutes"))
		}

		function k(j, m) {
			var t, X = j.length,
				z, l, s, da, pa, ra, qa, ua, x, J = "",
				$, S, oa = {}, ia = {}, va = v(),
				wa;
			t = e();
			var Ca = t > 1;
			if ($ = B("isRTL")) {
				S = -1;
				wa = t - 1
			} else {
				S = 1;
				wa = 0
			}
			for (t = 0; t < X; t++) {
				z = j[t];
				l = z.event;
				s = w(z.start, z.start);
				da = w(z.start, z.end);
				pa = z.col;
				ra = z.level;
				qa = z.forward || 0;
				ua = p(pa * S + wa);
				x = I(pa * S + wa) - ua;
				x = Math.min(x - 6, x * 0.95);
				pa = ra ? x / (ra + qa + 1) : qa ? Ca ? (x / (qa + 1) - 6) * 2 : (pa = x / (qa + 1)) : x;
				ra = ua + x / (ra + qa + 1) * ra * S + ($ ? x - pa : 0);
				z.top = s;
				z.left = ra;
				z.outerWidth = pa - (Ca ? 0 : 1);
				z.outerHeight = da - s;
				J += q(l, z)
			}
			va[0].innerHTML = J;
			$ = va.children();
			for (t = 0; t < X; t++) {
				z = j[t];
				l = z.event;
				J = o($[t]);
				S = la("eventRender", l, l, J);
				if (S === false) J.remove();
				else {
					if (S && S !== true) {
						J.remove();
						J = o(S).css({
							position: "absolute",
							top: z.top,
							left: z.left
						}).appendTo(va)
					}
					z.element = J;
					if (l._id === m) d(l, J, z);
					else J[0]._fci = t;
					E(l, J)
				}
			}
			Gb(va, j, d);
			for (t = 0; t < X; t++) {
				z = j[t];
				if (J = z.element) {
					l = oa[m = z.key = Lb(J[0])];
					z.vsides = l === sa ? (oa[m] = Ua(J, true)) : l;
					l = ia[m];
					z.hsides = l === sa ? (ia[m] = sb(J, true)) : l;
					m = J.find("div.fc-event-content");
					if (m.length) z.contentTop = m[0].offsetTop
				}
			}
			for (t = 0; t < X; t++) {
				z = j[t];
				if (J = z.element) {
					J[0].style.width = Math.max(0, z.outerWidth - z.hsides) + "px";
					oa = Math.max(0, z.outerHeight - z.vsides);
					J[0].style.height = oa + "px";
					l = z.event;
					if (z.contentTop !== sa && oa - z.contentTop < 10) {
						J.find("div.fc-event-time").text(ga(l.start, B("timeFormat")) + " - " + l.title);
						J.find("div.fc-event-title").remove()
					}
					la("eventAfterRender", l, l, J)
				}
			}
		}
		function q(j, m) {
			var t = "<",
				X = j.url,
				z = cb(j, B),
				l = z ? " style='" + z + "'" : "",
				s = ["fc-event", "fc-event-skin", "fc-event-vert"];
			ea(j) && s.push("fc-event-draggable");
			m.isStart && s.push("fc-corner-top");
			m.isEnd && s.push("fc-corner-bottom");
			s = s.concat(j.className);
			if (j.source) s = s.concat(j.source.className || []);
			t += X ? "a href='" + Ea(j.url) + "'" : "div";
			t += " class='" + s.join(" ") + "' style='position:absolute;z-index:8;top:" + m.top + "px;left:" + m.left + "px;" + z + "'><div class='fc-event-inner fc-event-skin'" + l + "><div class='fc-event-head fc-event-skin'" + l + "><div class='fc-event-time'>" + Ea(fa(j.start, j.end, B("timeFormat"))) + "</div></div><div class='fc-event-content'><div class='fc-event-title'>" + Ea(j.title) + "</div></div><div class='fc-event-bg'></div></div>";
			if (m.isEnd && na(j)) t += "<div class='ui-resizable-handle ui-resizable-s'>=</div>";
			t += "</" + (X ? "a" : "div") + ">";
			return t
		}
		function h(j, m, t) {
			ea(j) && O(j, m, t.isStart);
			t.isEnd && na(j) && ca(j, m, t);
			aa(j, m)
		}
		function d(j, m, t) {
			var X = m.find("div.fc-event-time");
			ea(j) && L(j, m, X);
			t.isEnd && na(j) && R(j, m, X);
			aa(j, m)
		}
		function r() {
			var j = ha(),
				m = j.children(".fc-timeline");
			if (m.length == 0) m = o("<hr>").addClass("fc-timeline").appendTo(j);
			var t = new Date;
			if (u.visStart < t && u.visEnd > t) {
				m.show();
				t = (t.getHours() * 60 * 60 + t.getMinutes() * 60 + t.getSeconds()) / 86400;
				m.css("top", Math.floor(j.height() * t - 1) + "px");
				if (u.name == "agendaWeek") {
					t = o(".fc-today", u.element);
					j = t.position().left + 1;
					t = t.width();
					m.css({
						left: j + "px",
						width: t + "px"
					})
				}
			} else m.hide()
		}
		function O(j, m, t) {
			function X() {
				if (!s) {
					m.width(z).height("").draggable("option", "grid", null);
					s = true
				}
			}
			var z, l, s = true,
				da, pa = B("isRTL") ? -1 : 1,
				ra = C(),
				qa = M(),
				ua = A(),
				x = W();
			m.draggable({
				zIndex: 9,
				opacity: B("dragOpacity", "month"),
				revertDuration: B("dragRevertDuration"),
				start: function(J, $) {
					la("eventDragStart", m, j, J, $);
					y(j, m);
					z = m.width();
					ra.start(function(S, oa, ia, va) {
						i();
						if (S) {
							l = false;
							da = va * pa;
							if (S.row) if (t) {
								if (s) {
									m.width(qa - 10);
									Hb(m, ua * Math.round((j.end ? (j.end - j.start) / xc : B("defaultEventMinutes")) / B("slotMinutes")));
									m.draggable("option", "grid", [qa, 1]);
									s = false
								}
							} else l = true;
							else {
								P(ka(G(j.start), da), ka(Wa(j), da));
								X()
							}
							l = l || s && !da
						} else {
							X();
							l = true
						}
						m.draggable("option", "revert", l)
					}, J, "drag")
				},
				stop: function(J, $) {
					ra.stop();
					i();
					la("eventDragStop", m, j, J, $);
					if (l) {
						X();
						m.css("filter", "");
						ma(j, m)
					} else {
						var S = 0;
						s || (S = Math.round((m.offset().top - ha().offset().top) / ua) * B("slotMinutes") + x - (j.start.getHours() * 60 + j.start.getMinutes()));
						Q(this, j, da, S, s, J, $)
					}
				}
			})
		}
		function L(j, m, t) {
			function X(S) {
				var oa = xa(G(j.start), S),
					ia;
				if (j.end) ia = xa(G(j.end), S);
				t.text(fa(oa, ia, B("timeFormat")))
			}
			function z() {
				if (s) {
					t.css("display", "");
					m.draggable("option", "grid", [J, $]);
					s = false
				}
			}
			var l, s = false,
				da, pa, ra, qa = B("isRTL") ? -1 : 1,
				ua = C(),
				x = e(),
				J = M(),
				$ = A();
			m.draggable({
				zIndex: 9,
				scroll: false,
				grid: [J, $],
				axis: x == 1 ? "y" : false,
				opacity: B("dragOpacity"),
				revertDuration: B("dragRevertDuration"),
				start: function(S, oa) {
					la("eventDragStart", m, j, S, oa);
					y(j, m);
					l = m.position();
					pa = ra = 0;
					ua.start(function(ia, va, wa, Ca) {
						m.draggable("option", "revert", !ia);
						i();
						if (ia) {
							da = Ca * qa;
							if (B("allDaySlot") && !ia.row) {
								if (!s) {
									s = true;
									t.hide();
									m.draggable("option", "grid", null)
								}
								P(ka(G(j.start), da), ka(Wa(j), da))
							} else z()
						}
					}, S, "drag")
				},
				drag: function(S, oa) {
					pa = Math.round((oa.position.top - l.top) / $) * B("slotMinutes");
					if (pa != ra) {
						s || X(pa);
						ra = pa
					}
				},
				stop: function(S, oa) {
					var ia = ua.stop();
					i();
					la("eventDragStop", m, j, S, oa);
					if (ia && (da || pa || s)) Q(this, j, da, s ? 0 : pa, s, S, oa);
					else {
						z();
						m.css("filter", "");
						m.css(l);
						X(0);
						ma(j, m)
					}
				}
			})
		}
		function R(j, m, t) {
			var X, z, l = A();
			m.resizable({
				handles: {
					s: "div.ui-resizable-s"
				},
				grid: l,
				start: function(s, da) {
					X = z = 0;
					y(j, m);
					m.css("z-index", 9);
					la("eventResizeStart", this, j, s, da)
				},
				resize: function(s, da) {
					X = Math.round((Math.max(l, m.height()) - da.originalSize.height) / l);
					if (X != z) {
						t.text(fa(j.start, !X && !j.end ? null : xa(T(j), B("slotMinutes") * X), B("timeFormat")));
						z = X
					}
				},
				stop: function(s, da) {
					la("eventResizeStop", this, j, s, da);
					if (X) H(this,
					j, 0, B("slotMinutes") * X, s, da);
					else {
						m.css("z-index", 8);
						ma(j, m)
					}
				}
			})
		}
		var u = this;
		u.renderEvents = a;
		u.compileDaySegs = g;
		u.clearEvents = b;
		u.slotSegHtml = q;
		u.bindDaySeg = h;
		wb.call(u);
		var B = u.opt,
			la = u.trigger,
			ea = u.isEventDraggable,
			na = u.isEventResizable,
			T = u.eventEnd,
			N = u.reportEvents,
			V = u.reportEventClear,
			aa = u.eventElementHandlers,
			Z = u.setHeight,
			ja = u.getDaySegmentContainer,
			v = u.getSlotSegmentContainer,
			C = u.getHoverListener,
			ba = u.getMaxMinute,
			W = u.getMinMinute,
			w = u.timePosition,
			p = u.colContentLeft,
			I = u.colContentRight,
			Y = u.renderDaySegs,
			ca = u.resizableDayEvent,
			e = u.getColCnt,
			M = u.getColWidth,
			A = u.getSlotHeight,
			ha = u.getBodyContent,
			E = u.reportEventElement,
			ma = u.showEvents,
			y = u.hideEvents,
			Q = u.eventDrop,
			H = u.eventResize,
			P = u.renderDayOverlay,
			i = u.clearOverlays,
			F = u.calendar,
			ga = F.formatDate,
			fa = F.formatDates,
			ya
	}
	function wc(a) {
		var b, g, c, f, k, q;
		for (b = a.length - 1; b > 0; b--) {
			f = a[b];
			for (g = 0; g < f.length; g++) {
				k = f[g];
				for (c = 0; c < a[b - 1].length; c++) {
					q = a[b - 1][c];
					if (Fb(k, q)) q.forward = Math.max(q.forward || 0, (k.forward || 0) + 1)
				}
			}
		}
	}
	function db(a, b, g) {
		function c(w, p) {
			w = W[w];
			if (typeof w == "object" && !w.length) return mb(w, p || g);
			return w
		}
		function f(w, p) {
			return b.trigger.apply(b, [w, p || V].concat(Array.prototype.slice.call(arguments, 2), [V]))
		}
		function k(w) {
			return h(w) && !c("disableDragging")
		}
		function q(w) {
			return h(w) && !c("disableResizing")
		}
		function h(w) {
			return Va(w.editable, (w.source || {}).editable, c("editable"))
		}
		function d(w) {
			v = {};
			var p, I = w.length,
				Y;
			for (p = 0; p < I; p++) {
				Y = w[p];
				if (v[Y._id]) v[Y._id].push(Y);
				else v[Y._id] = [Y]
			}
		}
		function r(w) {
			return w.end ? G(w.end) : aa(w)
		}
		function O(w, p) {
			C.push(p);
			if (ba[w._id]) ba[w._id].push(p);
			else ba[w._id] = [p]
		}
		function L() {
			C = [];
			ba = {}
		}
		function R(w, p) {
			p.click(function(I) {
				if (!p.hasClass("ui-draggable-dragging") && !p.hasClass("ui-resizable-resizing")) return f("eventClick", this, w, I)
			}).hover(function(I) {
				f("eventMouseover", this, w, I)
			}, function(I) {
				f("eventMouseout", this, w, I)
			})
		}
		function u(w, p) {
			la(w, p, "show")
		}
		function B(w, p) {
			la(w, p, "hide")
		}
		function la(w, p, I) {
			w = ba[w._id];
			var Y, ca = w.length;
			for (Y = 0; Y < ca; Y++) if (!p || w[Y][0] != p[0]) w[Y][I]()
		}
		function ea(w, p, I, Y, ca, e, M) {
			var A = p.allDay,
				ha = p._id;
			T(v[ha], I, Y, ca);
			f("eventDrop", w, p, I, Y, ca, function() {
				T(v[ha], -I, -Y, A);
				ja(ha)
			}, e, M);
			ja(ha)
		}
		function na(w, p, I, Y, ca, e) {
			var M = p._id;
			N(v[M], I, Y);
			f("eventResize", w, p, I, Y, function() {
				N(v[M], -I, -Y);
				ja(M)
			}, ca, e);
			ja(M)
		}
		function T(w, p, I, Y) {
			I = I || 0;
			for (var ca, e = w.length, M = 0; M < e; M++) {
				ca = w[M];
				if (Y !== sa) ca.allDay = Y;
				xa(ka(ca.start, p, true), I);
				if (ca.end) ca.end = xa(ka(ca.end, p, true), I);
				Z(ca, W)
			}
		}
		function N(w, p, I) {
			I = I || 0;
			for (var Y, ca = w.length, e = 0; e < ca; e++) {
				Y = w[e];
				Y.end = xa(ka(r(Y), p, true), I);
				Z(Y, W)
			}
		}
		var V = this;
		V.element = a;
		V.calendar = b;
		V.name = g;
		V.opt = c;
		V.trigger = f;
		V.isEventDraggable = k;
		V.isEventResizable = q;
		V.reportEvents = d;
		V.eventEnd = r;
		V.reportEventElement = O;
		V.reportEventClear = L;
		V.eventElementHandlers = R;
		V.showEvents = u;
		V.hideEvents = B;
		V.eventDrop = ea;
		V.eventResize = na;
		var aa = V.defaultEventEnd,
			Z = b.normalizeEvent,
			ja = b.reportEventChange,
			v = {}, C = [],
			ba = {}, W = b.options
	}
	function wb() {
		function a(y, Q) {
			var H = e(),
				P = v(),
				i = C(),
				F = 0,
				ga, fa, ya = y.length,
				j, m, t, X, z = la("maxHeight");
			H[0].innerHTML = c(y);
			f(y, H.children());
			k(y);
			q(y,
			H, Q);
			h(y);
			d(y);
			r(y);
			Q = O();
			for (H = 0; H < P; H++) {
				t = [];
				X = {};
				ga = [];
				for (fa = 0; fa < i; fa++) {
					t[fa] = 0;
					ga[fa] = 0
				}
				for (; F < ya && (j = y[F]).row == H;) {
					fa = Kb(ga.slice(j.startCol, j.endCol));
					if (z && fa + j.outerHeight > z) j.overflow = true;
					else {
						j.top = fa;
						fa += j.outerHeight
					}
					for (m = j.startCol; m < j.endCol; m++) {
						if (t[m]) j.overflow = true;
						if (j.overflow) {
							if (j.isStart && !X[m]) X[m] = {
								seg: j,
								top: fa,
								date: G(j.start, true),
								count: 0
							};
							X[m] && X[m].count++;
							t[m]++
						} else ga[m] = fa
					}
					F++
				}
				Q[H].height(Kb(ga));
				b(X, Q[H])
			}
			R(y, L(Q))
		}
		function b(y, Q) {
			for (var H = e(), P = C(), i, F, ga = 0; ga < P; ga++) if (F = y[ga]) if (F.count > 1) {
				i = o("<a>").addClass("fc-more-link").html("+" + F.count).appendTo(H);
				i[0].style.position = "absolute";
				i[0].style.left = F.seg.left + "px";
				i[0].style.top = F.top + Q[0].offsetTop + "px";
				F = ea("overflowRender", F, {
					count: F.count,
					date: F.date
				}, i);
				F === false && i.remove()
			} else {
				F.seg.top = F.top;
				F.seg.overflow = false
			}
		}
		function g(y, Q, H) {
			var P = o("<div/>"),
				i = e(),
				F = y.length,
				ga;
			P[0].innerHTML = c(y);
			P = P.children();
			i.append(P);
			f(y, P);
			h(y);
			d(y);
			r(y);
			R(y, L(O()));
			P = [];
			for (i = 0; i < F; i++) if (ga = y[i].element) {
				y[i].row === Q && ga.css("top", H);
				P.push(ga[0])
			}
			return o(P)
		}
		function c(y) {
			var Q = la("isRTL"),
				H, P = y.length,
				i, F, ga, fa;
			H = W();
			var ya = H.left,
				j = H.right,
				m, t, X, z, l, s = "";
			for (H = 0; H < P; H++) {
				i = y[H];
				F = i.event;
				fa = ["fc-event", "fc-event-skin", "fc-event-hori"];
				na(F) && fa.push("fc-event-draggable");
				if (Q) {
					i.isStart && fa.push("fc-corner-right");
					i.isEnd && fa.push("fc-corner-left");
					m = I(i.end.getDay() - 1);
					t = I(i.start.getDay());
					X = i.isEnd ? w(m) : ya;
					z = i.isStart ? p(t) : j
				} else {
					i.isStart && fa.push("fc-corner-left");
					i.isEnd && fa.push("fc-corner-right");
					m = I(i.start.getDay());
					t = I(i.end.getDay() - 1);
					X = i.isStart ? w(m) : ya;
					z = i.isEnd ? p(t) : j
				}
				fa = fa.concat(F.className);
				if (F.source) fa = fa.concat(F.source.className || []);
				ga = F.url;
				l = cb(F, la);
				s += ga ? "<a href='" + Ea(ga) + "'" : "<div";
				s += " class='" + fa.join(" ") + "' style='position:absolute;z-index:8;left:" + X + "px;" + l + "'><div class='fc-event-inner fc-event-skin'" + (l ? " style='" + l + "'" : "") + ">";
				if (!F.allDay && i.isStart) s += "<span class='fc-event-time'>" + Ea(A(F.start, F.end, la("timeFormat"))) + "</span>";
				s += "<span class='fc-event-title'>" + Ea(F.title) + "</span></div>";
				if (i.isEnd && T(F)) s += "<div class='ui-resizable-handle ui-resizable-" + (Q ? "w" : "e") + "'>&nbsp;&nbsp;&nbsp;</div>";
				s += "</" + (ga ? "a" : "div") + ">";
				i.left = X;
				i.outerWidth = z - X;
				i.startCol = m;
				i.endCol = t + 1
			}
			return s
		}
		function f(y, Q) {
			var H, P = y.length,
				i, F, ga;
			for (H = 0; H < P; H++) {
				i = y[H];
				F = i.event;
				ga = o(Q[H]);
				F = ea("eventRender", F, F, ga);
				if (F === false) ga.remove();
				else {
					if (F && F !== true) {
						F = o(F).css({
							position: "absolute",
							left: i.left
						});
						ga.replaceWith(F);
						ga = F
					}
					i.element = ga
				}
			}
		}
		function k(y) {
			var Q, H = y.length,
				P, i;
			for (Q = 0; Q < H; Q++) {
				P = y[Q];
				(i = P.element) && V(P.event, i)
			}
		}
		function q(y, Q, H) {
			var P, i = y.length,
				F, ga, fa;
			for (P = 0; P < i; P++) {
				F = y[P];
				if (ga = F.element) {
					fa = F.event;
					if (fa._id === H) M(fa, ga, F);
					else ga[0]._fci = P
				}
			}
			Gb(Q, y, M)
		}
		function h(y) {
			var Q, H = y.length,
				P, i, F, ga, fa = {};
			for (Q = 0; Q < H; Q++) {
				P = y[Q];
				if (i = P.element) {
					F = P.key = Lb(i[0]);
					ga = fa[F];
					if (ga === sa) ga = fa[F] = sb(i, true);
					P.hsides = ga
				}
			}
		}
		function d(y) {
			var Q, H = y.length,
				P, i;
			for (Q = 0; Q < H; Q++) {
				P = y[Q];
				if (i = P.element) i[0].style.width = Math.max(0, P.outerWidth - P.hsides) + "px"
			}
		}
		function r(y) {
			var Q,
			H = y.length,
				P, i, F, ga, fa = {};
			for (Q = 0; Q < H; Q++) {
				P = y[Q];
				if (i = P.element) {
					F = P.key;
					ga = fa[F];
					if (ga === sa) ga = fa[F] = Ib(i);
					P.outerHeight = i[0].offsetHeight + ga
				} else P.outerHeight = 0
			}
		}
		function O() {
			var y, Q = v(),
				H = [];
			for (y = 0; y < Q; y++) H[y] = ba(y).find("td:first div.fc-day-content > div");
			return H
		}
		function L(y) {
			var Q, H = y.length,
				P = [];
			for (Q = 0; Q < H; Q++) P[Q] = y[Q][0].offsetTop;
			return P
		}
		function R(y, Q) {
			var H, P = y.length,
				i, F;
			for (H = 0; H < P; H++) {
				i = y[H];
				if ((F = i.element) && !i.overflow) {
					F[0].style.top = Q[i.row] + (i.top || 0) + "px";
					i = i.event;
					ea("eventAfterRender",
					i, i, F)
				} else F && F.hide()
			}
		}
		function u(y, Q, H) {
			var P = la("isRTL"),
				i = P ? "w" : "e",
				F = Q.find("div.ui-resizable-" + i),
				ga = false;
			tb(Q);
			Q.mousedown(function(fa) {
				fa.preventDefault()
			}).click(function(fa) {
				if (ga) {
					fa.preventDefault();
					fa.stopImmediatePropagation()
				}
			});
			F.mousedown(function(fa) {
				function ya(qa) {
					ea("eventResizeStop", this, y, qa);
					o("body").css("cursor", "");
					j.stop();
					E();
					s && ja(this, y, s, 0, qa);
					setTimeout(function() {
						ga = false
					}, 0)
				}
				if (fa.which == 1) {
					ga = true;
					var j = B.getHoverListener(),
						m = v(),
						t = C(),
						X = P ? -1 : 1,
						z = P ? t - 1 : 0,
						l = Q.css("top"),
						s, da, pa = o.extend({}, y),
						ra = Y(y.start);
					ma();
					o("body").css("cursor", i + "-resize").one("mouseup", ya);
					ea("eventResizeStart", this, y, fa);
					j.start(function(qa, ua) {
						if (qa) {
							var x = Math.max(ra.row, qa.row);
							qa = qa.col;
							if (m == 1) x = 0;
							if (x == ra.row) qa = P ? Math.min(ra.col, qa) : Math.max(ra.col, qa);
							s = x * 7 + qa * X + z - (ua.row * 7 + ua.col * X + z);
							ua = ka(N(y), s, true);
							if (s) {
								pa.end = ua;
								x = da;
								da = g(ca([pa]), H.row, l);
								da.find("*").css("cursor", i + "-resize");
								x && x.remove();
								Z(y)
							} else if (da) {
								aa(y);
								da.remove();
								da = null
							}
							E();
							ha(y.start, ka(G(ua), 1))
						}
					}, fa)
				}
			})
		}
		var B = this;
		B.renderDaySegs = a;
		B.resizableDayEvent = u;
		var la = B.opt,
			ea = B.trigger,
			na = B.isEventDraggable,
			T = B.isEventResizable,
			N = B.eventEnd,
			V = B.reportEventElement,
			aa = B.showEvents,
			Z = B.hideEvents,
			ja = B.eventResize,
			v = B.getRowCnt,
			C = B.getColCnt,
			ba = B.allDayRow,
			W = B.allDayBounds,
			w = B.colContentLeft,
			p = B.colContentRight,
			I = B.dayOfWeekCol,
			Y = B.dateCell,
			ca = B.compileDaySegs,
			e = B.getDaySegmentContainer,
			M = B.bindDaySeg,
			A = B.calendar.formatDates,
			ha = B.renderDayOverlay,
			E = B.clearOverlays,
			ma = B.clearSelection
	}
	function Ob() {
		function a(L,
		R, u) {
			b();
			R || (R = h(L, u));
			d(L, R, u);
			g(L, R, u)
		}
		function b(L) {
			if (O) {
				O = false;
				r();
				q("unselect", null, L)
			}
		}
		function g(L, R, u, B) {
			O = true;
			q("select", null, L, R, u, B)
		}
		function c(L) {
			var R = f.cellDate,
				u = f.cellIsAllDay,
				B = f.getHoverListener(),
				la = f.reportDayClick;
			if (L.which == 1 && k("selectable")) {
				b(L);
				var ea;
				B.start(function(na, T) {
					r();
					if (na && u(na)) {
						ea = [R(T), R(na)].sort(Jb);
						d(ea[0], ea[1], true)
					} else ea = null
				}, L);
				o(document).one("mouseup", function(na) {
					B.stop();
					if (ea) {
						+ea[0] == +ea[1] && la(ea[0], true, na);
						g(ea[0], ea[1], true, na)
					}
				})
			}
		}
		var f = this;
		f.select = a;
		f.unselect = b;
		f.reportSelection = g;
		f.daySelectionMousedown = c;
		var k = f.opt,
			q = f.trigger,
			h = f.defaultSelectionEnd,
			d = f.renderSelection,
			r = f.clearSelection,
			O = false;
		k("selectable") && k("unselectAuto") && o(document).mousedown(function(L) {
			var R = k("unselectCancel");
			if (R) if (o(L.target).parents(R).length) return;
			b(L)
		})
	}
	function Nb() {
		function a(k, q) {
			var h = f.shift();
			h || (h = o("<div class='fc-cell-overlay' style='position:absolute;z-index:3'/>"));
			h[0].parentNode != q[0] && h.appendTo(q);
			c.push(h.css(k).show());
			return h
		}
		function b() {
			for (var k; k = c.shift();) f.push(k.hide().unbind())
		}
		var g = this;
		g.renderOverlay = a;
		g.clearOverlays = b;
		var c = [],
			f = []
	}
	function Pb(a) {
		var b = this,
			g, c;
		b.build = function() {
			g = [];
			c = [];
			a(g, c)
		};
		b.cell = function(f, k) {
			var q = g.length,
				h = c.length,
				d, r = -1,
				O = -1;
			for (d = 0; d < q; d++) if (k >= g[d][0] && k < g[d][1]) {
				r = d;
				break
			}
			for (d = 0; d < h; d++) if (f >= c[d][0] && f < c[d][1]) {
				O = d;
				break
			}
			return r >= 0 && O >= 0 ? {
				row: r,
				col: O
			} : null
		};
		b.rect = function(f, k, q, h, d) {
			d = d.offset();
			return {
				top: g[f][0] - d.top,
				left: c[k][0] - d.left,
				width: c[h][1] - c[k][0],
				height: g[q][1] - g[f][0]
			}
		}
	}
	function Qb(a) {
		function b(h) {
			yc(h);
			h = a.cell(h.pageX, h.pageY);
			if (!h != !q || h && (h.row != q.row || h.col != q.col)) {
				if (h) {
					k || (k = h);
					f(h, k, h.row - k.row, h.col - k.col)
				} else f(h, k);
				q = h
			}
		}
		var g = this,
			c, f, k, q;
		g.start = function(h, d, r) {
			f = h;
			k = q = null;
			a.build();
			b(d);
			c = r || "mousemove";
			o(document).bind(c, b)
		};
		g.stop = function() {
			o(document).unbind(c, b);
			return q
		}
	}
	function yc(a) {
		if (a.pageX === sa) {
			a.pageX = a.originalEvent.pageX;
			a.pageY = a.originalEvent.pageY
		}
	}
	function Rb(a) {
		function b(q) {
			return c[q] = c[q] || a(q)
		}
		var g = this,
			c = {}, f = {}, k = {};
		g.left = function(q) {
			return f[q] = f[q] === sa ? b(q).position().left : f[q]
		};
		g.right = function(q) {
			return k[q] = k[q] === sa ? g.left(q) + b(q).width() : k[q]
		};
		g.clear = function() {
			c = {};
			f = {};
			k = {}
		}
	}
	function Zb() {
		function a() {
			L();
			B().empty()
		}
		function b(T, N) {
			T.sort(c);
			O(T);
			f(g(T), N)
		}
		function g(T) {
			var N = [],
				V = d("titleFormat", "day"),
				aa = d("firstDay"),
				Z = d("listSections"),
				ja, v, C, ba, W, w, p, I = -1,
				Y = Ia(new Date),
				ca = ka(G(Y), -((Y.getDay() - aa + 7) % 7));
			for (ja = 0; ja < T.length; ja++) {
				aa = T[ja];
				if (!(aa.end < h.start || aa.start > h.visEnd)) {
					p = G(aa.start < h.start && aa.end > h.start ? h.start : aa.start, true);
					v = Ba(p, Y);
					C = Math.floor(Ba(p, ca) / 7);
					ba = p.getMonth() + (p.getYear() - Y.getYear()) * 12 - Y.getMonth();
					if (Z == "smart") if (v < 0) W = d("listTexts", "past");
					else if (v == 0) W = d("listTexts", "today");
					else if (v == 1) W = d("listTexts", "tomorrow");
					else if (C == 0) W = d("listTexts", "thisWeek");
					else if (C == 1) W = d("listTexts", "nextWeek");
					else if (ba == 0) W = d("listTexts", "thisMonth");
					else if (ba == 1) W = d("listTexts", "nextMonth");
					else {
						if (ba > 1) W = d("listTexts", "future")
					} else W = Z == "month" ? ea(p, "MMMM yyyy") : Z == "week" ? d("listTexts", "week") + ea(p, " W") : Z == "day" ? ea(p, V) : "";
					if (W != w) {
						N[++I] = {
							events: [],
							start: p,
							title: W,
							daydiff: v,
							weekdiff: C,
							monthdiff: ba
						};
						w = W
					}
					N[I].events.push(aa)
				}
			}
			return N
		}
		function c(T, N) {
			var V = T.start.getTime() - N.start.getTime();
			return V + (V ? 0 : T.end.getTime() - N.end.getTime())
		}
		function f(T, N) {
			var V = d("theme") ? "ui" : "fc",
				aa = V + "-widget-header";
			V = V + "-widget-content";
			var Z, ja, v, C, ba, W, w, p, I;
			for (ja = 0; ja < T.length; ja++) {
				v = T[ja];
				v.title && o('<div class="fc-list-header ' + aa + '">' + Ea(v.title) + "</div>").appendTo(B());
				I = o("<div>").addClass("fc-list-section " + V).appendTo(B());
				W = "";
				for (Z = 0; Z < v.events.length; Z++) {
					C = v.events[Z];
					ba = k(C, v);
					w = (w = cb(C, d)) ? " style='" + w + "'" : "";
					p = ["fc-event", "fc-event-skin", "fc-event-vert", "fc-corner-top", "fc-corner-bottom"].concat(C.className);
					if (C.source && C.source.className) p = p.concat(C.source.className);
					W += "<div class='" + p.join(" ") + "'" + w + "><div class='fc-event-inner fc-event-skin'" + w + "><div class='fc-event-head fc-event-skin'" + w + "><div class='fc-event-time'>" + (ba[0] ? '<span class="fc-col-date">' + ba[0] + "</span> " : "") + (ba[1] ? '<span class="fc-col-time">' + ba[1] + "</span>" : "") + "</div></div><div class='fc-event-content'><div class='fc-event-title'>" + Ea(C.title) + "</div></div><div class='fc-event-bg'></div></div></div>"
				}
				I[0].innerHTML = W;
				W = I.children();
				for (Z = 0; Z < v.events.length; Z++) {
					C = v.events[Z];
					ba = o(W[Z]);
					w = r("eventRender", C, C, ba);
					if (w === false) ba.remove();
					else {
						if (w && w !== true) {
							ba.remove();
							ba = o(w).appendTo(I)
						}
						if (C._id === N) u(C, ba, v);
						else ba[0]._fci = Z;
						R(C, ba)
					}
				}
				q(I,
				v, u)
			}
			Sa(B())
		}
		function k(T, N) {
			var V = d("timeFormat"),
				aa = d("columnFormat"),
				Z = d("listSections"),
				ja = T.end.getTime() - T.start.getTime(),
				v = "",
				C = "";
			if (Z == "smart") if (T.start < N.start) v = d("listTexts", "until") + " " + ea(T.end, T.allDay || T.end.getDate() != N.start.getDate() ? aa : V);
			else if (ja > Qa) v = na(T.start, T.end, aa + "{ - " + aa + "}");
			else if (N.daydiff == 0) v = d("listTexts", "today");
			else if (N.daydiff == 1) v = d("listTexts", "tomorrow");
			else if (N.weekdiff == 0 || N.weekdiff == 1) v = ea(T.start, "dddd");
			else {
				if (N.daydiff > 1 || N.daydiff < 0) v = ea(T.start,
				aa)
			} else if (Z != "day") v = na(T.start, T.end, aa + (ja > Qa ? "{ - " + aa + "}" : ""));
			if (!v && T.allDay) C = d("allDayText");
			else if ((ja < Qa || !v) && !T.allDay) C = na(T.start, T.end, V);
			return [v, C]
		}
		function q(T, N, V) {
			T.unbind("mouseover").mouseover(function(aa) {
				for (var Z = aa.target, ja = Z; Z != this;) {
					ja = Z;
					Z = Z.parentNode
				}
				if ((Z = ja._fci) !== sa) {
					ja._fci = sa;
					ja = N.events[Z];
					V(ja, T.children().eq(Z), N);
					o(aa.target).trigger(aa)
				}
				aa.stopPropagation()
			})
		}
		var h = this;
		h.renderEvents = b;
		h.renderEventTime = k;
		h.compileDaySegs = g;
		h.clearEvents = a;
		h.lazySegBind = q;
		h.sortCmp = c;
		wb.call(h);
		var d = h.opt,
			r = h.trigger,
			O = h.reportEvents,
			L = h.reportEventClear,
			R = h.reportEventElement,
			u = h.eventElementHandlers,
			B = h.getDaySegmentContainer,
			la = h.calendar,
			ea = la.formatDate,
			na = la.formatDates
	}
	function zc(a, b) {
		function g(na, T) {
			T && ka(na, r("listPage") * T);
			d.start = d.visStart = G(na, true);
			d.end = ka(G(d.start), r("listPage"));
			d.visEnd = ka(G(d.start), r("listRange"));
			xa(d.visEnd, -1);
			d.title = L(na, d.visEnd, r("titleFormat"));
			c();
			R ? O() : f()
		}
		function c() {
			u = r("firstDay");
			B = r("weekends") ? 0 : 1;
			la = r("theme") ?
				"ui" : "fc";
			ea = r("columnFormat", "day")
		}
		function f() {
			R = o("<div>").addClass("fc-list-content").appendTo(a)
		}
		function k(na) {
			r("listNoHeight") || R.css("height", na - 1 + "px").css("overflow", "auto")
		}
		function q() {}
		function h() {}
		var d = this;
		d.render = g;
		d.select = h;
		d.unselect = h;
		d.getDaySegmentContainer = function() {
			return R
		};
		db.call(d, a, b, "list");
		Zb.call(d);
		var r = d.opt,
			O = d.clearEvents,
			L = b.formatDates;
		d.setWidth = q;
		d.setHeight = k;
		var R, u, B, la, ea
	}
	function Ac() {
		function a() {
			r();
			u().children("tbody").remove()
		}
		function b(la,
		ea) {
			la.sort(k);
			d(la);
			g(h(la), ea);
			u().removeClass("fc-list-smart fc-list-day fc-list-month fc-list-week").addClass("fc-list-" + f("listSections"))
		}
		function g(la, ea) {
			var na = f("theme") ? "ui" : "fc",
				T = u(),
				N = na + "-widget-header";
			na = na + "-widget-content";
			var V = f("tableCols"),
				aa = o.inArray("time", V) >= 0,
				Z, ja, v, C, ba, W, w, p, I, Y;
			for (ja = 0; ja < la.length; ja++) {
				v = la[ja];
				v.title && o('<tbody class="fc-list-header"><tr><td class="fc-list-header ' + N + '" colspan="' + V.length + '">' + Ea(v.title) + "</td></tr></tbody>").appendTo(T);
				Y = o("<tbody>").addClass("fc-list-section " + na).appendTo(T);
				W = "";
				for (Z = 0; Z < v.events.length; Z++) {
					C = v.events[Z];
					ba = R(C, v);
					w = (w = cb(C, f)) ? " style='" + w + "'" : "";
					p = ["fc-event-skin", "fc-corner-left", "fc-corner-right", "fc-corner-top", "fc-corner-bottom"].concat(C.className);
					if (C.source && C.source.className) p = p.concat(C.source.className);
					I = ["fc-event", "fc-event-row", "fc-" + Mb[C.start.getDay()]];
					v.daydiff == 0 && I.push("fc-today");
					W += "<tr class='" + I.join(" ") + "'>";
					for (var ca = 0; ca < V.length; ca++) {
						I = V[ca];
						if (I == "handle") W += "<td class='fc-event-handle'><div class='" + p.join(" ") + "'" + w + "><span class='fc-event-inner'></span></div></td>";
						else if (I == "date") W += "<td class='fc-event-date' colspan='" + (ba[1] || !aa ? 1 : 2) + "'>" + Ea(ba[0]) + "</td>";
						else if (I == "time") {
							if (ba[1]) W += "<td class='fc-event-time'>" + Ea(ba[1]) + "</td>"
						} else W += "<td class='fc-event-" + I + "'>" + (C[I] ? Ea(C[I]) : "&nbsp;") + "</td>"
					}
					W += "</tr>";
					if (document.all) {
						o(W).appendTo(Y);
						W = ""
					}
				}
				if (!document.all) Y[0].innerHTML = W;
				ba = Y.children();
				for (Z = 0; Z < v.events.length; Z++) {
					C = v.events[Z];
					W = o(ba[Z]);
					w = q("eventRender", C, C, W);
					if (w === false) W.remove();
					else {
						if (w && w !== true) {
							W.remove();
							W = o(w).appendTo(Y)
						}
						if (C._id === ea) L(C, W, v);
						else W[0]._fci = Z;
						O(C, W)
					}
				}
				B(Y, v, L);
				Sa(Y)
			}
		}
		var c = this;
		Zb.call(c);
		var f = c.opt,
			k = c.sortCmp,
			q = c.trigger,
			h = c.compileDaySegs,
			d = c.reportEvents,
			r = c.reportEventClear,
			O = c.reportEventElement,
			L = c.eventElementHandlers,
			R = c.renderEventTime,
			u = c.getDaySegmentContainer,
			B = c.lazySegBind;
		c.renderEvents = b;
		c.clearEvents = a
	}
	function Bc(a, b) {
		function g(N, V) {
			V && ka(N, r("listPage") * V);
			d.start = d.visStart = G(N, true);
			d.end = ka(G(d.start), r("listPage"));
			d.visEnd = ka(G(d.start), r("listRange"));
			xa(d.visEnd, -1);
			d.title = d.visEnd.getTime() - d.visStart.getTime() < Qa ? R(N, r("titleFormat")) : L(N, d.visEnd, r("titleFormat"));
			c();
			B ? O() : f()
		}
		function c() {
			la = r("firstDay");
			ea = r("weekends") ? 0 : 1;
			na = r("theme") ? "ui" : "fc";
			T = r("columnFormat")
		}
		function f() {
			for (var N = r("tableCols"), V = "<table class='fc-border-separate' style='width:100%' cellspacing='0'><colgroup>", aa = 0; aa < N.length; aa++) V += "<col class='fc-event-" + N[aa] + "' />";
			V += "</colgroup></table>";
			u = o("<div>").addClass("fc-list-content").appendTo(a);
			B = o(V).appendTo(u)
		}
		function k(N) {
			r("listNoHeight") || u.css("height", N - 1 + "px").css("overflow", "auto")
		}
		function q() {}
		function h() {}
		var d = this;
		d.render = g;
		d.select = h;
		d.unselect = h;
		d.getDaySegmentContainer = function() {
			return B
		};
		db.call(d, a, b, "table");
		Ac.call(d);
		var r = d.opt,
			O = d.clearEvents,
			L = b.formatDates,
			R = b.formatDate;
		d.setWidth = q;
		d.setHeight = k;
		var u, B, la, ea, na, T
	}
	var $a = {
		defaultView: "month",
		aspectRatio: 1.35,
		header: {
			left: "title",
			center: "",
			right: "today prev,next"
		},
		weekends: false,
		currentTimeIndicator: false,
		allDayDefault: true,
		ignoreTimezone: true,
		lazyFetching: true,
		startParam: "start",
		endParam: "end",
		titleFormat: {
			month: "MMMM yyyy",
			week: "MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}",
			day: "dddd, MMM d, yyyy",
			list: "MMM d, yyyy",
			table: "MMM d, yyyy"
		},
		columnFormat: {
			month: "ddd",
			week: "ddd M/d",
			day: "dddd M/d",
			list: "dddd, MMM d, yyyy",
			table: "MMM d, yyyy"
		},
		timeFormat: {
			"": "h(:mm)t"
		},
		isRTL: false,
		firstDay: 0,
		monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
		monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
		dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
		buttonText: {
			prev: "&nbsp;&#9668;&nbsp;",
			next: "&nbsp;&#9658;&nbsp;",
			prevYear: "&nbsp;&lt;&lt;&nbsp;",
			nextYear: "&nbsp;&gt;&gt;&nbsp;",
			today: "today",
			month: "month",
			week: "week",
			day: "day",
			list: "list",
			table: "table"
		},
		listTexts: {
			until: "until",
			past: "Past events",
			today: "Today",
			tomorrow: "Tomorrow",
			thisWeek: "This week",
			nextWeek: "Next week",
			thisMonth: "This month",
			nextMonth: "Next month",
			future: "Future events",
			week: "W"
		},
		listSections: "month",
		listRange: 30,
		listPage: 7,
		tableCols: ["handle", "date", "time", "title"],
		theme: false,
		buttonIcons: {
			prev: "circle-triangle-w",
			next: "circle-triangle-e"
		},
		unselectAuto: true,
		dropAccept: "*"
	}, Cc = {
		header: {
			left: "next,prev today",
			center: "",
			right: "title"
		},
		buttonText: {
			prev: "&nbsp;&#9658;&nbsp;",
			next: "&nbsp;&#9668;&nbsp;",
			prevYear: "&nbsp;&gt;&gt;&nbsp;",
			nextYear: "&nbsp;&lt;&lt;&nbsp;"
		},
		buttonIcons: {
			prev: "circle-triangle-e",
			next: "circle-triangle-w"
		}
	}, Aa = o.fullCalendar = {
		version: "1.5.3-rcube-0.7.1"
	}, Ha = Aa.views = {};
	o.fn.fullCalendar = function(a) {
		if (typeof a == "string") {
			var b = Array.prototype.slice.call(arguments, 1),
				g;
			this.each(function() {
				var f = o.data(this, "fullCalendar");
				if (f && o.isFunction(f[a])) {
					f = f[a].apply(f, b);
					if (g === sa) g = f;
					a == "destroy" && o.removeData(this, "fullCalendar")
				}
			});
			if (g !== sa) return g;
			return this
		}
		var c = a.eventSources || [];
		delete a.eventSources;
		if (a.events) {
			c.push(a.events);
			delete a.events
		}
		a = o.extend(true, {}, $a, a.isRTL || a.isRTL === sa && $a.isRTL ? Cc : {}, a);
		this.each(function(f, k) {
			f = o(k);
			k = new $b(f, a, c);
			f.data("fullCalendar", k);
			k.render()
		});
		return this
	};
	Aa.sourceNormalizers = [];
	Aa.sourceFetchers = [];
	var cc = {
		dataType: "json",
		cache: false
	}, dc = 1;
	Aa.addDays = ka;
	Aa.cloneDate = G;
	Aa.parseDate = nb;
	Aa.parseISO8601 = Eb;
	Aa.parseTime = pb;
	Aa.formatDate = Pa;
	Aa.formatDates = lb;
	var Mb = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"],
		Qa = 864E5,
		ec = 36E5,
		xc = 6E4,
		fc = {
			s: function(a) {
				return a.getSeconds()
			},
			ss: function(a) {
				return Ra(a.getSeconds())
			},
			m: function(a) {
				return a.getMinutes()
			},
			mm: function(a) {
				return Ra(a.getMinutes())
			},
			h: function(a) {
				return a.getHours() % 12 || 12
			},
			hh: function(a) {
				return Ra(a.getHours() % 12 || 12)
			},
			H: function(a) {
				return a.getHours()
			},
			HH: function(a) {
				return Ra(a.getHours())
			},
			d: function(a) {
				return a.getDate()
			},
			dd: function(a) {
				return Ra(a.getDate())
			},
			ddd: function(a, b) {
				return b.dayNamesShort[a.getDay()]
			},
			dddd: function(a, b) {
				return b.dayNames[a.getDay()]
			},
			M: function(a) {
				return a.getMonth() + 1
			},
			MM: function(a) {
				return Ra(a.getMonth() + 1)
			},
			MMM: function(a,
			b) {
				return b.monthNamesShort[a.getMonth()]
			},
			MMMM: function(a, b) {
				return b.monthNames[a.getMonth()]
			},
			yy: function(a) {
				return (a.getFullYear() + "").substring(2)
			},
			yyyy: function(a) {
				return a.getFullYear()
			},
			t: function(a) {
				return a.getHours() < 12 ? "a" : "p"
			},
			tt: function(a) {
				return a.getHours() < 12 ? "am" : "pm"
			},
			T: function(a) {
				return a.getHours() < 12 ? "A" : "P"
			},
			TT: function(a) {
				return a.getHours() < 12 ? "AM" : "PM"
			},
			u: function(a) {
				return Pa(a, "yyyy-MM-dd'T'HH:mm:ss'Z'")
			},
			S: function(a) {
				a = a.getDate();
				if (a > 10 && a < 20) return "th";
				return ["st",
					"nd", "rd"][a % 10 - 1] || "th"
			},
			W: function(a) {
				return Dc(a)
			}
		}, Dc = function(a) {
			a = G(a);
			a.setDate(a.getDate() + 4 - (a.getDay() || 7));
			var b = a.getTime();
			a.setMonth(0);
			a.setDate(1);
			return Math.floor(Math.round((b - a) / 864E5) / 7) + 1
		};
	Aa.applyAll = bb;
	Ha.month = nc;
	Ha.basicWeek = oc;
	Ha.basicDay = pc;
	Ab({
		weekMode: "fixed"
	});
	Ha.agendaWeek = rc;
	Ha.agendaDay = sc;
	Ab({
		allDaySlot: false,
		allDayText: "all-day",
		firstHour: 6,
		slotMinutes: 30,
		defaultEventMinutes: 120,
		axisFormat: "h(:mm)tt",
		timeFormat: {
			agenda: "h:mm{ - h:mm}"
		},
		dragOpacity: {
			agenda: 0.5
		},
		minTime: 8,
		maxTime: 19
	});
	Ha.list = zc;
	Ha.table = Bc
})(jQuery);
(function(a) {
	a.fn.colorPicker = function() {
		this.length > 0 && buildSelector();
		return this.each(function() {
			buildPicker(this)
		})
	};
	var c, d = false;
	buildPicker = function(b) {
		control = a("<div class='color_picker'>&nbsp;</div>");
		control.css("background-color", a(b).val());
		control.bind("click", toggleSelector);
		a(b).after(control);
		a(b).bind("change", function() {
			selectedValue = toHex(a(b).val());
			a(b).next(".color_picker").css("background-color", selectedValue)
		});
		a(b).hide()
	};
	buildSelector = function() {
		selector = a("<div id='color_selector'></div>");
		a.each(a.fn.colorPicker.defaultColors, function() {
			swatch = a("<div class='color_swatch'>&nbsp;</div>");
			swatch.css("background-color", "#" + this);
			swatch.bind("click", function() {
				changeColor(a(this).css("background-color"))
			});
			swatch.bind("mouseover", function() {
				a(this).css("border-color", "#598FEF");
				a("input#color_value").val(toHex(a(this).css("background-color")))
			});
			swatch.bind("mouseout", function() {
				a(this).css("border-color", "#000");
				a("input#color_value").val(toHex(a(c).css("background-color")))
			});
			swatch.appendTo(selector)
		});
		hex_field = a("<label for='color_value'>Hex</label><input type='text' size='8' id='color_value'/>");
		hex_field.bind("keydown", function(b) {
			b.keyCode == 13 && changeColor(a(this).val());
			b.keyCode == 27 && toggleSelector()
		});
		a("<div id='color_custom'></div>").append(hex_field).appendTo(selector);
		a("body").append(selector);
		selector.hide()
	};
	checkMouse = function(b) {
		var e = a(b.target).parents("div#color_selector").length;
		b.target == a("div#color_selector")[0] || b.target == c || e > 0 || hideSelector()
	};
	hideSelector = function() {
		var b = a("div#color_selector");
		a(document).unbind("mousedown", checkMouse);
		b.hide();
		d = false
	};
	showSelector = function() {
		var b = a("div#color_selector");
		b.css({
			top: a(c).offset().top + a(c).outerHeight(),
			left: a(c).offset().left
		});
		hexColor = a(c).prev("input").val();
		a("input#color_value").val(hexColor);
		b.show();
		a(document).bind("mousedown", checkMouse);
		d = true
	};
	toggleSelector = function() {
		c = this;
		d ? hideSelector() : showSelector()
	};
	changeColor = function(b) {
		if (selectedValue = toHex(b)) a(c).css("background-color", selectedValue),
		a(c).prev("input").val(selectedValue).change(), hideSelector()
	};
	toHex = function(a) {
		if (a.match(/[0-9a-fA-F]{3}$/) || a.match(/[0-9a-fA-F]{6}$/)) a = a.charAt(0) == "#" ? a : "#" + a;
		else if (a.match(/^rgb\(([0-9]|[1-9][0-9]|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5]),[ ]{0,1}([0-9]|[1-9][0-9]|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5]),[ ]{0,1}([0-9]|[1-9][0-9]|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5])\)$/)) {
			var c = [parseInt(RegExp.$1), parseInt(RegExp.$2), parseInt(RegExp.$3)],
				d = function(a) {
					if (a.length < 2) for (var b = 0, c = 2 - a.length; b < c; b++) a = "0" + a;
					return a
				};
			if (c.length == 3) var a = d(c[0].toString(16)),
				f = d(c[1].toString(16)),
				c = d(c[2].toString(16)),
				a = "#" + a + f + c
		} else a = false;
		return a
	};
	a.fn.colorPicker.addColors = function(b) {
		a.fn.colorPicker.defaultColors = a.fn.colorPicker.defaultColors.concat(b)
	};
	a.fn.colorPicker.defaultColors = "000000,993300,333300,000080,333399,333333,800000,FF6600,808000,008000,008080,0000FF,666699,808080,FF0000,FF9900,99CC00,339966,33CCCC,3366FF,800080,999999,FF00FF,FFCC00,FFFF00,00FF00,00FFFF,00CCFF,993366,C0C0C0,FF99CC,FFCC99,FFFF99,CCFFFF,99CCFF,FFFFFF".split(",")
})(jQuery);
/*! qTip2 v2.0.0 | http://craigsworks.com/projects/qtip2/ | Licensed MIT, GPL */ (function(a) {
	"use strict", typeof define == "function" && define.amd ? define(["jquery"], a) : jQuery && !jQuery.fn.qtip && a(jQuery)
})(function(a) {
	function G() {
		G.history = G.history || [], G.history.push(arguments);
		if ("object" == typeof console) {
			var a = console[console.warn ? "warn" : "log"],
				b = Array.prototype.slice.call(arguments),
				c;
			typeof arguments[0] == "string" && (b[0] = "qTip2: " + b[0]), c = a.apply ? a.apply(console, b) : a(b)
		}
	}
	function H(b) {
		var e = function(a) {
			return a === d || "object" != typeof a
		}, f = function(b) {
			return !a.isFunction(b) && (!b && !b.attr || b.length < 1 || "object" == typeof b && !b.jquery)
		};
		if (!b || "object" != typeof b) return c;
		e(b.metadata) && (b.metadata = {
			type: b.metadata
		});
		if ("content" in b) {
			if (e(b.content) || b.content.jquery) b.content = {
				text: b.content
			};
			f(b.content.text || c) && (b.content.text = c), "title" in b.content && (e(b.content.title) && (b.content.title = {
				text: b.content.title
			}), f(b.content.title.text || c) && (b.content.title.text = c))
		}
		return "position" in b && e(b.position) && (b.position = {
			my: b.position,
			at: b.position
		}), "show" in b && e(b.show) && (b.show = b.show.jquery ? {
			target: b.show
		} : {
			event: b.show
		}), "hide" in b && e(b.hide) && (b.hide = b.hide.jquery ? {
			target: b.hide
		} : {
			event: b.hide
		}), "style" in b && e(b.style) && (b.style = {
			classes: b.style
		}), a.each(r, function() {
			this.sanitize && this.sanitize(b)
		}), b
	}
	function I(e, f, n, o) {
		function N(a) {
			var b = 0,
				c, d = f,
				e = a.split(".");
			while (d = d[e[b++]]) b < e.length && (c = d);
			return [c || f, e.pop()]
		}
		function O() {
			var a = f.style.widget;
			J.toggleClass(v, a).toggleClass(y, f.style.def && !a), L.content.toggleClass(v + "-content", a), L.titlebar && L.titlebar.toggleClass(v + "-header", a), L.button && L.button.toggleClass(u + "-icon", !a)
		}
		function P(a) {
			L.title && (L.titlebar.remove(), L.titlebar = L.title = L.button = d, a !== c && p.reposition())
		}
		function Q() {
			var b = f.content.title.button,
				d = typeof b == "string",
				e = d ? b : "Close tooltip";
			L.button && L.button.remove(), b.jquery ? L.button = b : L.button = a("<a />", {
				"class": "ui-state-default ui-tooltip-close " + (f.style.widget ? "" : u + "-icon"),
				title: e,
				"aria-label": e
			}).prepend(a("<span />", {
				"class": "ui-icon ui-icon-close",
				html: "&times;"
			})), L.button.appendTo(L.titlebar).attr("role", "button").click(function(a) {
				return J.hasClass(w) || p.hide(a), c
			}), p.redraw()
		}
		function R() {
			var c = D + "-title";
			L.titlebar && P(), L.titlebar = a("<div />", {
				"class": u + "-titlebar " + (f.style.widget ? "ui-widget-header" : "")
			}).append(L.title = a("<div />", {
				id: c,
				"class": u + "-title",
				"aria-atomic": b
			})).insertBefore(L.content).delegate(".ui-tooltip-close", "mousedown keydown mouseup keyup mouseout", function(b) {
				a(this).toggleClass("ui-state-active ui-state-focus", b.type.substr(-4) === "down")
			}).delegate(".ui-tooltip-close", "mouseover mouseout", function(b) {
				a(this).toggleClass("ui-state-hover", b.type === "mouseover")
			}), f.content.title.button ? Q() : p.rendered && p.redraw()
		}
		function S(a) {
			var b = L.button,
				d = L.title;
			if (!p.rendered) return c;
			a ? (d || R(), Q()) : b.remove()
		}
		function T(b, d) {
			var f = L.title;
			if (!p.rendered || !b) return c;
			a.isFunction(b) && (b = b.call(e, M.event, p));
			if (b === c || !b && b !== "") return P(c);
			b.jquery && b.length > 0 ? f.empty().append(b.css({
				display: "block"
			})) : f.html(b), p.redraw(), d !== c && p.rendered && J[0].offsetWidth > 0 && p.reposition(M.event)
		}
		function U(b, d) {
			function g(b) {
				function h(e) {
					e && (delete g[e.src], clearTimeout(p.timers.img[e.src]), a(e).unbind(K)), a.isEmptyObject(g) && (p.redraw(), d !== c && p.reposition(M.event), b())
				}
				var e, g = {};
				if ((e = f.find("img[src]:not([height]):not([width])")).length === 0) return h();
				e.each(function(b, c) {
					if (g[c.src] !== undefined) return;
					var d = 0,
						e = 3;
					(function f() {
						if (c.height || c.width || d > e) return h(c);
						d += 1, p.timers.img[c.src] = setTimeout(f, 700)
					})(), a(c).bind("error" + K + " load" + K, function() {
						h(this)
					}), g[c.src] = c
				})
			}
			var f = L.content;
			return !p.rendered || !b ? c : (a.isFunction(b) && (b = b.call(e, M.event, p) || ""), b.jquery && b.length > 0 ? f.empty().append(b.css({
				display: "block"
			})) : f.html(b), p.rendered < 0 ? J.queue("fx", g) : (I = 0, g(a.noop)), p)
		}
		function V() {
			function j(a) {
				if (J.hasClass(w)) return c;
				clearTimeout(p.timers.show), clearTimeout(p.timers.hide);
				var d = function() {
					p.toggle(b, a)
				};
				f.show.delay > 0 ? p.timers.show = setTimeout(d, f.show.delay) : d()
			}
			function k(b) {
				if (J.hasClass(w) || G || I) return c;
				var e = a(b.relatedTarget || b.target),
					h = e.closest(x)[0] === J[0],
					i = e[0] === g.show[0];
				clearTimeout(p.timers.show), clearTimeout(p.timers.hide);
				if (d.target === "mouse" && h || f.hide.fixed && /mouse(out|leave|move)/.test(b.type) && (h || i)) {
					try {
						b.preventDefault(), b.stopImmediatePropagation()
					} catch (j) {}
					return
				}
				f.hide.delay > 0 ? p.timers.hide = setTimeout(function() {
					p.hide(b)
				}, f.hide.delay) : p.hide(b)
			}
			function l(a) {
				if (J.hasClass(w)) return c;
				clearTimeout(p.timers.inactive), p.timers.inactive = setTimeout(function() {
					p.hide(a)
				}, f.hide.inactive)
			}
			function m(a) {
				p.rendered && J[0].offsetWidth > 0 && p.reposition(a)
			}
			var d = f.position,
				g = {
					show: f.show.target,
					hide: f.hide.target,
					viewport: a(d.viewport),
					document: a(document),
					body: a(document.body),
					window: a(window)
				}, h = {
					show: a.trim("" + f.show.event).split(" "),
					hide: a.trim("" + f.hide.event).split(" ")
				}, i = a.browser.msie && parseInt(a.browser.version, 10) === 6;
			J.bind("mouseenter" + K + " mouseleave" + K, function(a) {
				var b = a.type === "mouseenter";
				b && p.focus(a), J.toggleClass(A, b)
			}), /mouse(out|leave)/i.test(f.hide.event) && f.hide.leave === "window" && g.window.bind("mouseout" + K + " blur" + K, function(a) {
				!/select|option/.test(a.target.nodeName) && !a.relatedTarget && p.hide(a)
			}), f.hide.fixed ? (g.hide = g.hide.add(J), J.bind("mouseover" + K, function() {
				J.hasClass(w) || clearTimeout(p.timers.hide)
			})) : /mouse(over|enter)/i.test(f.show.event) && g.hide.bind("mouseleave" + K, function(a) {
				clearTimeout(p.timers.show)
			}), ("" + f.hide.event).indexOf("unfocus") > -1 && d.container.closest("html").bind("mousedown" + K, function(b) {
				var c = a(b.target),
					d = p.rendered && !J.hasClass(w) && J[0].offsetWidth > 0,
					f = c.parents(x).filter(J[0]).length > 0;
				c[0] !== e[0] && c[0] !== J[0] && !f && !e.has(c[0]).length && !c.attr("disabled") && p.hide(b)
			}), "number" == typeof f.hide.inactive && (g.show.bind("qtip-" + n + "-inactive", l), a.each(q.inactiveEvents, function(a, b) {
				g.hide.add(L.tooltip).bind(b + K + "-inactive", l)
			})), a.each(h.hide, function(b, c) {
				var d = a.inArray(c, h.show),
					e = a(g.hide);
				d > -1 && e.add(g.show).length === e.length || c === "unfocus" ? (g.show.bind(c + K, function(a) {
					J[0].offsetWidth > 0 ? k(a) : j(a)
				}), delete h.show[d]) : g.hide.bind(c + K, k)
			}), a.each(h.show, function(a, b) {
				g.show.bind(b + K, j)
			}), "number" == typeof f.hide.distance && g.show.add(J).bind("mousemove" + K, function(a) {
				var b = M.origin || {}, c = f.hide.distance,
					d = Math.abs;
				(d(a.pageX - b.pageX) >= c || d(a.pageY - b.pageY) >= c) && p.hide(a)
			}), d.target === "mouse" && (g.show.bind("mousemove" + K, function(a) {
				s = {
					pageX: a.pageX,
					pageY: a.pageY,
					type: "mousemove"
				}
			}), d.adjust.mouse && (f.hide.event && (J.bind("mouseleave" + K, function(a) {
				(a.relatedTarget || a.target) !== g.show[0] && p.hide(a)
			}), L.target.bind("mouseenter" + K + " mouseleave" + K, function(a) {
				M.onTarget = a.type === "mouseenter"
			})), g.document.bind("mousemove" + K, function(a) {
				p.rendered && M.onTarget && !J.hasClass(w) && J[0].offsetWidth > 0 && p.reposition(a || s)
			}))), (d.adjust.resize || g.viewport.length) && (a.event.special.resize ? g.viewport : g.window).bind("resize" + K, m), (g.viewport.length || i && J.css("position") === "fixed") && g.viewport.bind("scroll" + K, m)
		}
		function W() {
			var b = [f.show.target[0], f.hide.target[0], p.rendered && L.tooltip[0], f.position.container[0], f.position.viewport[0], window, document];
			p.rendered ? a([]).pushStack(a.grep(b, function(a) {
				return typeof a == "object"
			})).unbind(K) : f.show.target.unbind(K + "-create")
		}
		var p = this,
			C = document.body,
			D = u + "-" + n,
			G = 0,
			I = 0,
			J = a(),
			K = ".qtip-" + n,
			L, M;
		p.id = n, p.rendered = c, p.destroyed = c, p.elements = L = {
			target: e
		}, p.timers = {
			img: {}
		}, p.options = f, p.checks = {}, p.plugins = {}, p.cache = M = {
			event: {},
			target: a(),
			disabled: c,
			attr: o,
			onTarget: c,
			lastClass: ""
		}, p.checks.builtin = {
			"^id$": function(d, e, f) {
				var g = f === b ? q.nextid : f,
					h = u + "-" + g;
				g !== c && g.length > 0 && !a("#" + h).length && (J[0].id = h, L.content[0].id = h + "-content", L.title[0].id = h + "-title")
			},
			"^content.text$": function(a, b, c) {
				U(c)
			},
			"^content.title.text$": function(a, b, c) {
				if (!c) return P();
				!L.title && c && R(), T(c)
			},
			"^content.title.button$": function(a, b, c) {
				S(c)
			},
			"^position.(my|at)$": function(a, b, c) {
				"string" == typeof c && (a[b] = new r.Corner(c))
			},
			"^position.container$": function(a, b, c) {
				p.rendered && J.appendTo(c)
			},
			"^show.ready$": function() {
				p.rendered ? p.toggle(b) : p.render(1)
			},
			"^style.classes$": function(a, b, c) {
				J.attr("class", u + " qtip ui-helper-reset " + c)
			},
			"^style.widget|content.title": O,
			"^events.(render|show|move|hide|focus|blur)$": function(b, c, d) {
				J[(a.isFunction(d) ? "" : "un") + "bind"]("tooltip" + c, d)
			},
			"^(show|hide|position).(event|target|fixed|inactive|leave|distance|viewport|adjust)": function() {
				var a = f.position;
				J.attr("tracking", a.target === "mouse" && a.adjust.mouse), W(), V()
			}
		}, a.extend(p, {
			render: function(d) {
				if (p.rendered) return p;
				var g = f.content.text,
					h = f.content.title.text,
					i = f.position,
					j = a.Event("tooltiprender");
				return a.attr(e[0], "aria-describedby", D), J = L.tooltip = a("<div/>", {
					id: D,
					"class": u + " qtip ui-helper-reset " + y + " " + f.style.classes + " " + u + "-pos-" + f.position.my.abbrev(),
					width: f.style.width || "",
					height: f.style.height || "",
					tracking: i.target === "mouse" && i.adjust.mouse,
					role: "alert",
					"aria-live": "polite",
					"aria-atomic": c,
					"aria-describedby": D + "-content",
					"aria-hidden": b
				}).toggleClass(w, M.disabled).data("qtip", p).appendTo(f.position.container).append(L.content = a("<div />", {
					"class": u + "-content",
					id: D + "-content",
					"aria-atomic": b
				})), p.rendered = -1, I = 1, G = 1, h && (R(), a.isFunction(h) || T(h, c)), a.isFunction(g) || U(g, c), p.rendered = b, O(), a.each(f.events, function(b, c) {
					a.isFunction(c) && J.bind(b === "toggle" ? "tooltipshow tooltiphide" : "tooltip" + b, c)
				}), a.each(r, function() {
					this.initialize === "render" && this(p)
				}), V(), J.queue("fx", function(a) {
					j.originalEvent = M.event, J.trigger(j, [p]), I = 0, G = 0, p.redraw(), (f.show.ready || d) && p.toggle(b, M.event, c), a()
				}), p
			},
			get: function(a) {
				var b, c;
				switch (a.toLowerCase()) {
					case "dimensions":
						b = {
							height: J.outerHeight(),
							width: J.outerWidth()
						};
						break;
					case "offset":
						b = r.offset(J, f.position.container);
						break;
					default:
						c = N(a.toLowerCase()), b = c[0][c[1]], b = b.precedance ? b.string() : b
				}
				return b
			},
			set: function(e, g) {
				function n(a, b) {
					var c, d, e;
					for (c in l) for (d in l[c]) if (e = (new RegExp(d, "i")).exec(a)) b.push(e), l[c][d].apply(p, b)
				}
				var h = /^position\.(my|at|adjust|target|container)|style|content|show\.ready/i,
					i = /^content\.(title|attr)|style/i,
					j = c,
					k = c,
					l = p.checks,
					m;
				return "string" == typeof e ? (m = e, e = {}, e[m] = g) : e = a.extend(b, {}, e), a.each(e, function(b, c) {
					var d = N(b.toLowerCase()),
						f;
					f = d[0][d[1]], d[0][d[1]] = "object" == typeof c && c.nodeType ? a(c) : c, e[b] = [d[0], d[1], c, f], j = h.test(b) || j, k = i.test(b) || k
				}), H(f), G = I = 1, a.each(e, n), G = I = 0, p.rendered && J[0].offsetWidth > 0 && (j && p.reposition(f.position.target === "mouse" ? d : M.event), k && p.redraw()), p
			},
			toggle: function(e, g) {
				function u() {
					e ? (a.browser.msie && J[0].style.removeAttribute("filter"), J.css("overflow", ""), "string" == typeof i.autofocus && a(i.autofocus, J).focus(), i.target.trigger("qtip-" + n + "-inactive")) : J.css({
						display: "",
						visibility: "",
						opacity: "",
						left: "",
						top: ""
					}), t = a.Event("tooltip" + (e ? "visible" : "hidden")), t.originalEvent = g ? M.event : d, J.trigger(t, [p])
				}
				if (!p.rendered) return e ? p.render(1) : p;
				var h = e ? "show" : "hide",
					i = f[h],
					j = f[e ? "hide" : "show"],
					k = f.position,
					l = f.content,
					m = J[0].offsetWidth > 0,
					o = e || i.target.length === 1,
					q = !g || i.target.length < 2 || M.target[0] === g.target,
					r, t;
				(typeof e).search("boolean|number") && (e = !m);
				if (!J.is(":animated") && m === e && q) return p;
				if (g) {
					if (/over|enter/.test(g.type) && /out|leave/.test(M.event.type) && f.show.target.add(g.target).length === f.show.target.length && J.has(g.relatedTarget).length) return p;
					M.event = a.extend({}, g)
				}
				return t = a.Event("tooltip" + h), t.originalEvent = g ? M.event : d, J.trigger(t, [p, 90]), t.isDefaultPrevented() ? p : (a.attr(J[0], "aria-hidden", !e), e ? (M.origin = a.extend({}, s), p.focus(g), a.isFunction(l.text) && U(l.text, c), a.isFunction(l.title.text) && T(l.title.text, c), !F && k.target === "mouse" && k.adjust.mouse && (a(document).bind("mousemove.qtip", function(a) {
					s = {
						pageX: a.pageX,
						pageY: a.pageY,
						type: "mousemove"
					}
				}), F = b), p.reposition(g, arguments[2]), (t.solo = !! i.solo) && a(x, i.solo).not(J).qtip("hide", t)) : (clearTimeout(p.timers.show), delete M.origin, F && !a(x + '[tracking="true"]:visible', i.solo).not(J).length && (a(document).unbind("mousemove.qtip"), F = c), p.blur(g)), i.effect === c || o === c ? (J[h](), u.call(J)) : a.isFunction(i.effect) ? (J.stop(1, 1), i.effect.call(J, p), J.queue("fx", function(a) {
					u(), a()
				})) : J.fadeTo(90, e ? 1 : 0, u), e && i.target.trigger("qtip-" + n + "-inactive"), p)
			},
			show: function(a) {
				return p.toggle(b, a)
			},
			hide: function(a) {
				return p.toggle(c, a)
			},
			focus: function(b) {
				if (!p.rendered) return p;
				var c = a(x),
					d = parseInt(J[0].style.zIndex, 10),
					e = q.zindex + c.length,
					f = a.extend({}, b),
					g, h;
				return J.hasClass(z) || (h = a.Event("tooltipfocus"), h.originalEvent = f, J.trigger(h, [p, e]), h.isDefaultPrevented() || (d !== e && (c.each(function() {
					this.style.zIndex > d && (this.style.zIndex = this.style.zIndex - 1)
				}), c.filter("." + z).qtip("blur", f)), J.addClass(z)[0].style.zIndex = e)), p
			},
			blur: function(b) {
				var c = a.extend({}, b),
					d;
				return J.removeClass(z), d = a.Event("tooltipblur"), d.originalEvent = c, J.trigger(d, [p]), p
			},
			reposition: function(b, d) {
				if (!p.rendered || G) return p;
				G = 1;
				var e = f.position.target,
					g = f.position,
					h = g.my,
					n = g.at,
					o = g.adjust,
					q = o.method.split(" "),
					t = J.outerWidth(),
					u = J.outerHeight(),
					v = 0,
					w = 0,
					x = a.Event("tooltipmove"),
					y = J.css("position") === "fixed",
					z = g.viewport,
					A = {
						left: 0,
						top: 0
					}, B = g.container,
					C = J[0].offsetWidth > 0,
					D, E, F;
				if (a.isArray(e) && e.length === 2) n = {
					x: j,
					y: i
				}, A = {
					left: e[0],
					top: e[1]
				};
				else if (e === "mouse" && (b && b.pageX || M.event.pageX)) n = {
					x: j,
					y: i
				}, b = (b && (b.type === "resize" || b.type === "scroll") ? M.event : b && b.pageX && b.type === "mousemove" ? b : s && s.pageX && (o.mouse || !b || !b.pageX) ? {
					pageX: s.pageX,
					pageY: s.pageY
				} : !o.mouse && M.origin && M.origin.pageX && f.show.distance ? M.origin : b) || b || M.event || s || {}, A = {
					top: b.pageY,
					left: b.pageX
				};
				else {
					e === "event" && b && b.target && b.type !== "scroll" && b.type !== "resize" ? M.target = a(b.target) : e !== "event" && (M.target = a(e.jquery ? e : L.target)), e = M.target, e = a(e).eq(0);
					if (e.length === 0) return p;
					e[0] === document || e[0] === window ? (v = r.iOS ? window.innerWidth : e.width(), w = r.iOS ? window.innerHeight : e.height(), e[0] === window && (A = {
						top: (z || e).scrollTop(),
						left: (z || e).scrollLeft()
					})) : r.imagemap && e.is("area") ? D = r.imagemap(p, e, n, r.viewport ? q : c) : r.svg && typeof e[0].xmlbase == "string" ? D = r.svg(p, e, n, r.viewport ? q : c) : (v = e.outerWidth(), w = e.outerHeight(), A = r.offset(e, B)), D && (v = D.width, w = D.height, E = D.offset, A = D.position);
					if (r.iOS > 3.1 && r.iOS < 4.1 || r.iOS >= 4.3 && r.iOS < 4.33 || !r.iOS && y) F = a(window), A.left -= F.scrollLeft(), A.top -= F.scrollTop();
					A.left += n.x === l ? v : n.x === m ? v / 2 : 0, A.top += n.y === k ? w : n.y === m ? w / 2 : 0
				}
				return A.left += o.x + (h.x === l ? -t : h.x === m ? -t / 2 : 0), A.top += o.y + (h.y === k ? -u : h.y === m ? -u / 2 : 0), r.viewport ? (A.adjusted = r.viewport(p, A, g, v, w, t, u), E && A.adjusted.left && (A.left += E.left), E && A.adjusted.top && (A.top += E.top)) : A.adjusted = {
					left: 0,
					top: 0
				}, x.originalEvent = a.extend({}, b), J.trigger(x, [p, A, z.elem || z]), x.isDefaultPrevented() ? p : (delete A.adjusted, d === c || !C || isNaN(A.left) || isNaN(A.top) || e === "mouse" || !a.isFunction(g.effect) ? J.css(A) : a.isFunction(g.effect) && (g.effect.call(J, p, a.extend({}, A)), J.queue(function(b) {
					a(this).css({
						opacity: "",
						height: ""
					}), a.browser.msie && this.style.removeAttribute("filter"), b()
				})), G = 0, p)
			},
			redraw: function() {
				if (p.rendered < 1 || I) return p;
				var a = f.position.container,
					b, c, d, e;
				return I = 1, f.style.height && J.css(h, f.style.height), f.style.width ? J.css(g, f.style.width) : (J.css(g, "").addClass(B), c = J.width() + 1, d = J.css("max-width") || "", e = J.css("min-width") || "", b = (d + e).indexOf("%") > -1 ? a.width() / 100 : 0, d = (d.indexOf("%") > -1 ? b : 1) * parseInt(d, 10) || c, e = (e.indexOf("%") > -1 ? b : 1) * parseInt(e, 10) || 0, c = d + e ? Math.min(Math.max(c, e), d) : c, J.css(g, Math.round(c)).removeClass(B)), I = 0, p
			},
			disable: function(b) {
				return "boolean" != typeof b && (b = !J.hasClass(w) && !M.disabled), p.rendered ? (J.toggleClass(w, b), a.attr(J[0], "aria-disabled", b)) : M.disabled = !! b, p
			},
			enable: function() {
				return p.disable(c)
			},
			destroy: function() {
				var c = e[0],
					d = a.attr(c, E),
					g = e.data("qtip");
				p.destroyed = b, p.rendered && (J.stop(1, 0).remove(), a.each(p.plugins, function() {
					this.destroy && this.destroy()
				})), clearTimeout(p.timers.show), clearTimeout(p.timers.hide), W();
				if (!g || p === g) a.removeData(c, "qtip"), f.suppress && d && (a.attr(c, "title", d), e.removeAttr(E)), e.removeAttr("aria-describedby");
				return e.unbind(".qtip-" + n), delete t[p.id], e
			}
		})
	}
	function J(e, f) {
		var g, h, i, j, k, l = a(this),
			m = a(document.body),
			n = this === document ? m : l,
			o = l.metadata ? l.metadata(f.metadata) : d,
			p = f.metadata.type === "html5" && o ? o[f.metadata.name] : d,
			s = l.data(f.metadata.name || "qtipopts");
		try {
			s = typeof s == "string" ? a.parseJSON(s) : s
		} catch (t) {
			G("Unable to parse HTML5 attribute data: " + s)
		}
		j = a.extend(b, {}, q.defaults, f, typeof s == "object" ? H(s) : d, H(p || o)), h = j.position, j.id = e;
		if ("boolean" == typeof j.content.text) {
			i = l.attr(j.content.attr);
			if (j.content.attr !== c && i) j.content.text = i;
			else return G("Unable to locate content for tooltip! Aborting render of tooltip on element: ", l), c
		}
		h.container.length || (h.container = m), h.target === c && (h.target = n), j.show.target === c && (j.show.target = n), j.show.solo === b && (j.show.solo = h.container.closest("body")), j.hide.target === c && (j.hide.target = n), j.position.viewport === b && (j.position.viewport = h.container), h.container = h.container.eq(0), h.at = new r.Corner(h.at), h.my = new r.Corner(h.my);
		if (a.data(this, "qtip")) if (j.overwrite) l.qtip("destroy");
		else if (j.overwrite === c) return c;
		return j.suppress && (k = a.attr(this, "title")) && a(this).removeAttr("title").attr(E, k).attr("title", ""), g = new I(l, j, e, !! i), a.data(this, "qtip", g), l.bind("remove.qtip-" + e + " removeqtip.qtip-" + e, function() {
			g.destroy()
		}), g
	}
	function K(d) {
		var e = this,
			f = d.elements.tooltip,
			g = d.options.content.ajax,
			h = q.defaults.content.ajax,
			i = ".qtip-ajax",
			j = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
			k = b,
			l = c,
			m;
		d.checks.ajax = {
			"^content.ajax": function(a, b, c) {
				b === "ajax" && (g = c), b === "once" ? e.init() : g && g.url ? e.load() : f.unbind(i)
			}
		}, a.extend(e, {
			init: function() {
				return g && g.url && f.unbind(i)[g.once ? "one" : "bind"]("tooltipshow" + i, e.load), e
			},
			load: function(f) {
				function r() {
					var e;
					if (d.destroyed) return;
					k = c, p && (l = b, d.show(f.originalEvent)), (e = h.complete || g.complete) && a.isFunction(e) && e.apply(g.context || d, arguments)
				}
				function s(b, c, e) {
					var f;
					if (d.destroyed) return;
					o && (b = a("<div/>").append(b.replace(j, "")).find(o)), (f = h.success || g.success) && a.isFunction(f) ? f.call(g.context || d, b, c, e) : d.set("content.text", b)
				}
				function t(a, b, c) {
					if (d.destroyed || a.status === 0) return;
					d.set("content.text", b + ": " + c)
				}
				if (l) {
					l = c;
					return
				}
				var i = g.url.indexOf(" "),
					n = g.url,
					o, p = !g.loading && k;
				if (p) try {
					f.preventDefault()
				} catch (q) {} else if (f && f.isDefaultPrevented()) return e;
				m && m.abort && m.abort(), i > -1 && (o = n.substr(i), n = n.substr(0, i)), m = a.ajax(a.extend({
					error: h.error || t,
					context: d
				}, g, {
					url: n,
					success: s,
					complete: r
				}))
			},
			destroy: function() {
				m && m.abort && m.abort(), d.destroyed = b
			}
		}), e.init()
	}
	function L(a, b, c) {
		var d = Math.ceil(b / 2),
			e = Math.ceil(c / 2),
			f = {
				bottomright: [
					[0, 0],
					[b, c],
					[b, 0]
				],
				bottomleft: [
					[0, 0],
					[b, 0],
					[0, c]
				],
				topright: [
					[0, c],
					[b, 0],
					[b, c]
				],
				topleft: [
					[0, 0],
					[0, c],
					[b, c]
				],
				topcenter: [
					[0, c],
					[d, 0],
					[b, c]
				],
				bottomcenter: [
					[0, 0],
					[b, 0],
					[d, c]
				],
				rightcenter: [
					[0, 0],
					[b, e],
					[0, c]
				],
				leftcenter: [
					[b, 0],
					[b, c],
					[0, e]
				]
			};
		return f.lefttop = f.bottomright, f.righttop = f.bottomleft, f.leftbottom = f.topright, f.rightbottom = f.topleft, f[a.string()]
	}
	function M(n, o) {
		function C() {
			w.width = s.height, w.height = s.width
		}
		function D() {
			w.width = s.width, w.height = s.height
		}
		function E(a, d, g, h) {
			if (!t.tip) return;
			var o = q.corner.clone(),
				r = g.adjusted,
				u = n.options.position.adjust.method.split(" "),
				w = u[0],
				x = u[1] || u[0],
				y = {
					left: c,
					top: c,
					x: 0,
					y: 0
				}, z, A = {}, B;
			q.corner.fixed !== b && (w === p && o.precedance === e && r.left && o.y !== m ? o.precedance = o.precedance === e ? f : e : w !== p && r.left && (o.x = o.x === m ? r.left > 0 ? j : l : o.x === j ? l : j), x === p && o.precedance === f && r.top && o.x !== m ? o.precedance = o.precedance === f ? e : f : x !== p && r.top && (o.y = o.y === m ? r.top > 0 ? i : k : o.y === i ? k : i), o.string() !== v.corner.string() && (v.top !== r.top || v.left !== r.left) && q.update(o, c)), z = q.position(o, r), z[o.x] += F(o, o.x, b), z[o.y] += F(o, o.y, b), z.right !== undefined && (z.left = -z.right), z.bottom !== undefined && (z.top = -z.bottom), z.user = Math.max(0, s.offset);
			if (y.left = w === p && !! r.left) o.x === m ? A["margin-left"] = y.x = z["margin-left"] - r.left : (B = z.right !== undefined ? [r.left, -z.left] : [-r.left, z.left], (y.x = Math.max(B[0], B[1])) > B[0] && (g.left -= r.left, y.left = c), A[z.right !== undefined ? l : j] = y.x);
			if (y.top = x === p && !! r.top) o.y === m ? A["margin-top"] = y.y = z["margin-top"] - r.top : (B = z.bottom !== undefined ? [r.top, -z.top] : [-r.top, z.top], (y.y = Math.max(B[0], B[1])) > B[0] && (g.top -= r.top, y.top = c), A[z.bottom !== undefined ? k : i] = y.y);
			t.tip.css(A).toggle(!(y.x && y.y || o.x === m && y.y || o.y === m && y.x)), g.left -= z.left.charAt ? z.user : w !== p || y.top || !y.left && !y.top ? z.left : 0, g.top -= z.top.charAt ? z.user : x !== p || y.left || !y.left && !y.top ? z.top : 0, v.left = r.left, v.top = r.top, v.corner = o.clone()
		}
		function F(a, b, c) {
			b = b ? b : a[a.precedance];
			var d = u.hasClass(B),
				e = t.titlebar && a.y === i,
				f = e ? t.titlebar : t.tooltip,
				g = "border-" + b + "-width",
				h;
			return u.addClass(B), h = parseInt(f.css(g), 10), h = (c ? h || parseInt(u.css(g), 10) : h) || 0, u.toggleClass(B, d), h
		}
		function G(b) {
			function j(a) {
				return parseInt(d.css(a), 10) || parseInt(u.css(a), 10)
			}
			var c = t.titlebar && b.y === i,
				d = c ? t.titlebar : t.content,
				e = a.browser.mozilla,
				f = e ? "-moz-" : a.browser.webkit ? "-webkit-" : "",
				g = "border-radius-" + b.y + b.x,
				h = "border-" + b.y + "-" + b.x + "-radius";
			return j(h) || j(f + h) || j(f + g) || j(g) || 0
		}
		function H(a) {
			var b = a.precedance === f,
				c = w[b ? g : h],
				d = w[b ? h : g],
				e = a.string().indexOf(m) > -1,
				i = c * (e ? .5 : 1),
				j = Math.pow,
				k = Math.round,
				l, n, o, p = Math.sqrt(j(i, 2) + j(d, 2)),
				q = [y / i * p, y / d * p];
			return q[2] = Math.sqrt(j(q[0], 2) - j(y, 2)), q[3] = Math.sqrt(j(q[1], 2) - j(y, 2)), l = p + q[2] + q[3] + (e ? 0 : q[0]), n = l / p, o = [k(n * d), k(n * c)], {
				height: o[b ? 0 : 1],
				width: o[b ? 1 : 0]
			}
		}
		var q = this,
			s = n.options.style.tip,
			t = n.elements,
			u = t.tooltip,
			v = {
				top: 0,
				left: 0
			}, w = {
				width: s.width,
				height: s.height
			}, x = {}, y = s.border || 0,
			z = ".qtip-tip",
			A = !! (a("<canvas />")[0] || {}).getContext;
		q.corner = d, q.mimic = d, q.border = y, q.offset = s.offset, q.size = w, n.checks.tip = {
			"^position.my|style.tip.(corner|mimic|border)$": function() {
				q.init() || q.destroy(), n.reposition()
			},
			"^style.tip.(height|width)$": function() {
				w = {
					width: s.width,
					height: s.height
				}, q.create(), q.update(), n.reposition()
			},
			"^content.title.text|style.(classes|widget)$": function() {
				t.tip && t.tip.length && q.update()
			}
		}, a.extend(q, {
			init: function() {
				var b = q.detectCorner() && (A || a.browser.msie);
				return b && (q.create(), q.update(), u.unbind(z).bind("tooltipmove" + z, E)), b
			},
			detectCorner: function() {
				var a = s.corner,
					d = n.options.position,
					e = d.at,
					f = d.my.string ? d.my.string() : d.my;
				return a === c || f === c && e === c ? c : (a === b ? q.corner = new r.Corner(f) : a.string || (q.corner = new r.Corner(a), q.corner.fixed = b), v.corner = new r.Corner(q.corner.string()), q.corner.string() !== "centercenter")
			},
			detectColours: function(b) {
				var c, d, e, f = t.tip.css("cssText", ""),
					g = b || q.corner,
					h = g[g.precedance],
					j = "border-" + h + "-color",
					k = "border" + h.charAt(0) + h.substr(1) + "Color",
					l = /rgba?\(0, 0, 0(, 0)?\)|transparent|#123456/i,
					n = "background-color",
					o = "transparent",
					p = " !important",
					r = t.titlebar && (g.y === i || g.y === m && f.position().top + w.height / 2 + s.offset < t.titlebar.outerHeight(1)),
					v = r ? t.titlebar : t.tooltip;
				u.addClass(B), x.fill = d = f.css(n), x.border = e = f[0].style[k] || f.css(j) || u.css(j);
				if (!d || l.test(d)) x.fill = v.css(n) || o, l.test(x.fill) && (x.fill = u.css(n) || d);
				if (!e || l.test(e) || e === a(document.body).css("color")) {
					x.border = v.css(j) || o;
					if (l.test(x.border) || x.border === v.css("color")) x.border = u.css(j) || u.css(k) || e
				}
				a("*", f).add(f).css("cssText", n + ":" + o + p + ";border:0" + p + ";"), u.removeClass(B)
			},
			create: function() {
				var b = w.width,
					c = w.height,
					d;
				t.tip && t.tip.remove(), t.tip = a("<div />", {
					"class": "ui-tooltip-tip"
				}).css({
					width: b,
					height: c
				}).prependTo(u), A ? a("<canvas />").appendTo(t.tip)[0].getContext("2d").save() : (d = '<vml:shape coordorigin="0,0" style="display:inline-block; position:absolute; behavior:url(#default#VML);"></vml:shape>', t.tip.html(d + d), a("*", t.tip).bind("click mousedown", function(a) {
					a.stopPropagation()
				}))
			},
			update: function(g, h) {
				var n = t.tip,
					o = n.children(),
					p = w.width,
					z = w.height,
					B = "px solid ",
					E = "px dashed transparent",
					G = s.mimic,
					I = Math.round,
					J, K, M, N, O;
				g || (g = v.corner || q.corner), G === c ? G = g : (G = new r.Corner(G), G.precedance = g.precedance, G.x === "inherit" ? G.x = g.x : G.y === "inherit" ? G.y = g.y : G.x === G.y && (G[g.precedance] = g[g.precedance])), J = G.precedance, g.precedance === e ? C() : D(), t.tip.css({
					width: p = w.width,
					height: z = w.height
				}), q.detectColours(g), x.border !== "transparent" ? (y = F(g, d, b), s.border === 0 && y > 0 && (x.fill = x.border), q.border = y = s.border !== b ? s.border : y) : q.border = y = 0, M = L(G, p, z), q.size = O = H(g), n.css(O), g.precedance === f ? N = [I(G.x === j ? y : G.x === l ? O.width - p - y : (O.width - p) / 2), I(G.y === i ? O.height - z : 0)] : N = [I(G.x === j ? O.width - p : 0), I(G.y === i ? y : G.y === k ? O.height - z - y : (O.height - z) / 2)], A ? (o.attr(O), K = o[0].getContext("2d"), K.restore(), K.save(), K.clearRect(0, 0, 3e3, 3e3), K.fillStyle = x.fill, K.strokeStyle = x.border, K.lineWidth = y * 2, K.lineJoin = "miter", K.miterLimit = 100, K.translate(N[0], N[1]), K.beginPath(), K.moveTo(M[0][0], M[0][1]), K.lineTo(M[1][0], M[1][1]), K.lineTo(M[2][0], M[2][1]), K.closePath(), y && (u.css("background-clip") === "border-box" && (K.strokeStyle = x.fill, K.stroke()), K.strokeStyle = x.border, K.stroke()), K.fill()) : (M = "m" + M[0][0] + "," + M[0][1] + " l" + M[1][0] + "," + M[1][1] + " " + M[2][0] + "," + M[2][1] + " xe", N[2] = y && /^(r|b)/i.test(g.string()) ? parseFloat(a.browser.version, 10) === 8 ? 2 : 1 : 0, o.css({
					antialias: "" + (G.string().indexOf(m) > -1),
					left: N[0] - N[2] * Number(J === e),
					top: N[1] - N[2] * Number(J === f),
					width: p + y,
					height: z + y
				}).each(function(b) {
					var c = a(this);
					c[c.prop ? "prop" : "attr"]({
						coordsize: p + y + " " + (z + y),
						path: M,
						fillcolor: x.fill,
						filled: !! b,
						stroked: !b
					}).css({
						display: y || b ? "block" : "none"
					}), !b && c.html() === "" && c.html('<vml:stroke weight="' + y * 2 + 'px" color="' + x.border + '" miterlimit="1000" joinstyle="miter" ' + ' style="behavior:url(#default#VML); display:inline-block;" />')
				})), h !== c && q.position(g)
			},
			position: function(b) {
				var d = t.tip,
					k = {}, l = Math.max(0, s.offset),
					n, o, p;
				return s.corner === c || !d ? c : (b = b || q.corner, n = b.precedance, o = H(b), p = [b.x, b.y], n === e && p.reverse(), a.each(p, function(a, c) {
					var d, e;
					c === m ? (d = n === f ? j : i, k[d] = "50%", k["margin-" + d] = -Math.round(o[n === f ? g : h] / 2) + l) : (d = F(b, c), e = G(b), k[c] = a ? 0 : l + (e > d ? e : -d))
				}), k[b[n]] -= o[n === e ? g : h], d.css({
					top: "",
					bottom: "",
					left: "",
					right: "",
					margin: ""
				}).css(k), k)
			},
			destroy: function() {
				t.tip && t.tip.remove(), t.tip = !1, u.unbind(z)
			}
		}), q.init()
	}
	function N(d) {
		function q() {
			o = a(n, h).not("[disabled]").map(function() {
				return typeof this.focus == "function" ? this : null
			})
		}
		function s(a) {
			o.length < 1 && a.length ? a.not("body").blur() : o.first().focus()
		}
		function t(b) {
			var d = a(b.target),
				e = d.closest(".qtip"),
				f;
			f = e.length < 1 ? c : parseInt(e[0].style.zIndex, 10) > parseInt(h[0].style.zIndex, 10), !f && a(b.target).closest(x)[0] !== h[0] && s(d)
		}
		var e = this,
			f = d.options.show.modal,
			g = d.elements,
			h = g.tooltip,
			i = "#qtip-overlay",
			j = ".qtipmodal",
			k = j + d.id,
			l = "is-modal-qtip",
			m = a(document.body),
			n = r.modal.focusable.join(","),
			o = {}, p;
		d.checks.modal = {
			"^show.modal.(on|blur)$": function() {
				e.init(), g.overlay.toggle(h.is(":visible"))
			},
			"^content.text$": function() {
				q()
			}
		}, a.extend(e, {
			init: function() {
				return f.on ? (p = e.create(), h.attr(l, b).css("z-index", r.modal.zindex + a(x + "[" + l + "]").length).unbind(j).unbind(k).bind("tooltipshow" + j + " tooltiphide" + j, function(b, c, d) {
					var f = b.originalEvent;
					if (b.target === h[0]) if (f && b.type === "tooltiphide" && /mouse(leave|enter)/.test(f.type) && a(f.relatedTarget).closest(p[0]).length) try {
						b.preventDefault()
					} catch (g) {} else(!f || f && !f.solo) && e[b.type.replace("tooltip", "")](b, d)
				}).bind("tooltipfocus" + j, function(b) {
					if (b.isDefaultPrevented() || b.target !== h[0]) return;
					var c = a(x).filter("[" + l + "]"),
						d = r.modal.zindex + c.length,
						e = parseInt(h[0].style.zIndex, 10);
					p[0].style.zIndex = d - 2, c.each(function() {
						this.style.zIndex > e && (this.style.zIndex -= 1)
					}), c.end().filter("." + z).qtip("blur", b.originalEvent), h.addClass(z)[0].style.zIndex = d;
					try {
						b.preventDefault()
					} catch (f) {}
				}).bind("tooltiphide" + j, function(b) {
					b.target === h[0] && a("[" + l + "]").filter(":visible").not(h).last().qtip("focus", b)
				}), f.escape && a(document).unbind(k).bind("keydown" + k, function(a) {
					a.keyCode === 27 && h.hasClass(z) && d.hide(a)
				}), f.blur && g.overlay.unbind(k).bind("click" + k, function(a) {
					h.hasClass(z) && d.hide(a)
				}), q(), e) : e
			},
			create: function() {
				function d() {
					p.css({
						height: a(window).height(),
						width: a(window).width()
					})
				}
				var b = a(i);
				return b.length ? g.overlay = b.insertAfter(a(x).last()) : (p = g.overlay = a("<div />", {
					id: i.substr(1),
					html: "<div></div>",
					mousedown: function() {
						return c
					}
				}).hide().insertAfter(a(x).last()), a(window).unbind(j).bind("resize" + j, d), d(), p)
			},
			toggle: function(d, g, i) {
				if (d && d.isDefaultPrevented()) return e;
				var j = f.effect,
					n = g ? "show" : "hide",
					o = p.is(":visible"),
					q = a("[" + l + "]").filter(":visible").not(h),
					r;
				return p || (p = e.create()), p.is(":animated") && o === g || !g && q.length ? e : (g ? (p.css({
					left: 0,
					top: 0
				}), p.toggleClass("blurs", f.blur), f.stealfocus !== c && (m.bind("focusin" + k, t), s(a("body *")))) : m.unbind("focusin" + k), p.stop(b, c), a.isFunction(j) ? j.call(p, g) : j === c ? p[n]() : p.fadeTo(parseInt(i, 10) || 90, g ? 1 : 0, function() {
					g || a(this).hide()
				}), g || p.queue(function(a) {
					p.css({
						left: "",
						top: ""
					}), a()
				}), e)
			},
			show: function(a, c) {
				return e.toggle(a, b, c)
			},
			hide: function(a, b) {
				return e.toggle(a, c, b)
			},
			destroy: function() {
				var b = p;
				return b && (b = a("[" + l + "]").not(h).length < 1, b ? (g.overlay.remove(), a(document).unbind(j)) : g.overlay.unbind(j + d.id), m.undelegate("*", "focusin" + k)), h.removeAttr(l).unbind(j)
			}
		}), e.init()
	}
	function O(b) {
		var c = this,
			d = b.elements,
			e = d.tooltip,
			f = ".bgiframe-" + b.id;
		a.extend(c, {
			init: function() {
				d.bgiframe = a('<iframe class="ui-tooltip-bgiframe" frameborder="0" tabindex="-1" src="javascript:\'\';"  style="display:block; position:absolute; z-index:-1; filter:alpha(opacity=0); -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";"></iframe>'), d.bgiframe.appendTo(e), e.bind("tooltipmove" + f, c.adjust)
			},
			adjust: function() {
				var a = b.get("dimensions"),
					c = b.plugins.tip,
					f = d.tip,
					g, h;
				h = parseInt(e.css("border-left-width"), 10) || 0, h = {
					left: -h,
					top: -h
				}, c && f && (g = c.corner.precedance === "x" ? ["width", "left"] : ["height", "top"], h[g[1]] -= f[g[0]]()), d.bgiframe.css(h).css(a)
			},
			destroy: function() {
				d.bgiframe.remove(), e.unbind(f)
			}
		}), c.init()
	}
	"use strict";
	var b = !0,
		c = !1,
		d = null,
		e = "x",
		f = "y",
		g = "width",
		h = "height",
		i = "top",
		j = "left",
		k = "bottom",
		l = "right",
		m = "center",
		n = "flip",
		o = "flipinvert",
		p = "shift",
		q, r, s, t = {}, u = "ui-tooltip",
		v = "ui-widget",
		w = "ui-state-disabled",
		x = "div.qtip." + u,
		y = u + "-default",
		z = u + "-focus",
		A = u + "-hover",
		B = u + "-fluid",
		C = "-31000px",
		D = "_replacedByqTip",
		E = "oldtitle",
		F;
	q = a.fn.qtip = function(e, f, g) {
		var h = ("" + e).toLowerCase(),
			i = d,
			j = a.makeArray(arguments).slice(1),
			k = j[j.length - 1],
			l = this[0] ? a.data(this[0], "qtip") : d;
		if (!arguments.length && l || h === "api") return l;
		if ("string" == typeof e) return this.each(function() {
			var d = a.data(this, "qtip");
			if (!d) return b;
			k && k.timeStamp && (d.cache.event = k);
			if (h !== "option" && h !== "options" || !f) d[h] && d[h].apply(d[h], j);
			else if (a.isPlainObject(f) || g !== undefined) d.set(f, g);
			else return i = d.get(f), c
		}), i !== d ? i : this;
		if ("object" == typeof e || !arguments.length) return l = H(a.extend(b, {}, e)), q.bind.call(this, l, k)
	}, q.bind = function(d, e) {
		return this.each(function(f) {
			function m(b) {
				function d() {
					k.render(typeof b == "object" || g.show.ready), h.show.add(h.hide).unbind(j)
				}
				if (k.cache.disabled) return c;
				k.cache.event = a.extend({}, b), k.cache.target = b ? a(b.target) : [undefined], g.show.delay > 0 ? (clearTimeout(k.timers.show), k.timers.show = setTimeout(d, g.show.delay), i.show !== i.hide && h.hide.bind(i.hide, function() {
					clearTimeout(k.timers.show)
				})) : d()
			}
			var g, h, i, j, k, l;
			l = a.isArray(d.id) ? d.id[f] : d.id, l = !l || l === c || l.length < 1 || t[l] ? q.nextid++ : t[l] = l, j = ".qtip-" + l + "-create", k = J.call(this, l, d);
			if (k === c) return b;
			g = k.options, a.each(r, function() {
				this.initialize === "initialize" && this(k)
			}), h = {
				show: g.show.target,
				hide: g.hide.target
			}, i = {
				show: a.trim("" + g.show.event).replace(/ /g, j + " ") + j,
				hide: a.trim("" + g.hide.event).replace(/ /g, j + " ") + j
			}, /mouse(over|enter)/i.test(i.show) && !/mouse(out|leave)/i.test(i.hide) && (i.hide += " mouseleave" + j), h.show.bind("mousemove" + j, function(a) {
				s = {
					pageX: a.pageX,
					pageY: a.pageY,
					type: "mousemove"
				}, k.cache.onTarget = b
			}), h.show.bind(i.show, m), (g.show.ready || g.prerender) && m(e)
		})
	}, r = q.plugins = {
		Corner: function(a) {
			a = ("" + a).replace(/([A-Z])/, " $1").replace(/middle/gi, m).toLowerCase(), this.x = (a.match(/left|right/i) || a.match(/center/) || ["inherit"])[0].toLowerCase(), this.y = (a.match(/top|bottom|center/i) || ["inherit"])[0].toLowerCase();
			var b = a.charAt(0);
			this.precedance = b === "t" || b === "b" ? f : e, this.string = function() {
				return this.precedance === f ? this.y + this.x : this.x + this.y
			}, this.abbrev = function() {
				var a = this.x.substr(0, 1),
					b = this.y.substr(0, 1);
				return a === b ? a : this.precedance === f ? b + a : a + b
			}, this.invertx = function(a) {
				this.x = this.x === j ? l : this.x === l ? j : a || this.x
			}, this.inverty = function(a) {
				this.y = this.y === i ? k : this.y === k ? i : a || this.y
			}, this.clone = function() {
				return {
					x: this.x,
					y: this.y,
					precedance: this.precedance,
					string: this.string,
					abbrev: this.abbrev,
					clone: this.clone,
					invertx: this.invertx,
					inverty: this.inverty
				}
			}
		},
		offset: function(b, c) {
			function j(a, b) {
				d.left += b * a.scrollLeft(), d.top += b * a.scrollTop()
			}
			var d = b.offset(),
				e = b.closest("body")[0],
				f = c,
				g, h, i;
			if (f) {
				do f.css("position") !== "static" && (h = f.position(), d.left -= h.left + (parseInt(f.css("borderLeftWidth"), 10) || 0) + (parseInt(f.css("marginLeft"), 10) || 0), d.top -= h.top + (parseInt(f.css("borderTopWidth"), 10) || 0) + (parseInt(f.css("marginTop"), 10) || 0), !g && (i = f.css("overflow")) !== "hidden" && i !== "visible" && (g = f));
				while ((f = a(f[0].offsetParent)).length);
				g && g[0] !== e && j(g, 1)
			}
			return d
		},
		iOS: parseFloat(("" + (/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(navigator.userAgent) || [0, ""])[1]).replace("undefined", "3_2").replace("_", ".").replace("_", "")) || c,
		fn: {
			attr: function(b, c) {
				if (this.length) {
					var d = this[0],
						e = "title",
						f = a.data(d, "qtip");
					if (b === e && f && "object" == typeof f && f.options.suppress) return arguments.length < 2 ? a.attr(d, E) : (f && f.options.content.attr === e && f.cache.attr && f.set("content.text", c), this.attr(E, c))
				}
				return a.fn["attr" + D].apply(this, arguments)
			},
			clone: function(b) {
				var c = a([]),
					d = "title",
					e = a.fn["clone" + D].apply(this, arguments);
				return b || e.filter("[" + E + "]").attr("title", function() {
					return a.attr(this, E)
				}).removeAttr(E), e
			}
		}
	}, a.each(r.fn, function(c, d) {
		if (!d || a.fn[c + D]) return b;
		var e = a.fn[c + D] = a.fn[c];
		a.fn[c] = function() {
			return d.apply(this, arguments) || e.apply(this, arguments)
		}
	}), a.ui || (a["cleanData" + D] = a.cleanData, a.cleanData = function(b) {
		for (var c = 0, d;
		(d = b[c]) !== undefined; c++) try {
			a(d).triggerHandler("removeqtip")
		} catch (e) {}
		a["cleanData" + D](b)
	}), q.version = "@VERSION", q.nextid = 0, q.inactiveEvents = "click dblclick mousedown mouseup mousemove mouseleave mouseenter".split(" "), q.zindex = 15e3, q.defaults = {
		prerender: c,
		id: c,
		overwrite: b,
		suppress: b,
		content: {
			text: b,
			attr: "title",
			title: {
				text: c,
				button: c
			}
		},
		position: {
			my: "top left",
			at: "bottom right",
			target: c,
			container: c,
			viewport: c,
			adjust: {
				x: 0,
				y: 0,
				mouse: b,
				resize: b,
				method: "flip flip"
			},
			effect: function(b, d, e) {
				a(this).animate(d, {
					duration: 200,
					queue: c
				})
			}
		},
		show: {
			target: c,
			event: "mouseenter",
			effect: b,
			delay: 90,
			solo: c,
			ready: c,
			autofocus: c
		},
		hide: {
			target: c,
			event: "mouseleave",
			effect: b,
			delay: 0,
			fixed: c,
			inactive: c,
			leave: "window",
			distance: c
		},
		style: {
			classes: "",
			widget: c,
			width: c,
			height: c,
			def: b
		},
		events: {
			render: d,
			move: d,
			show: d,
			hide: d,
			toggle: d,
			visible: d,
			hidden: d,
			focus: d,
			blur: d
		}
	}, r.svg = function(b, c, d, e) {
		var f = a(document),
			g = c[0],
			h = {
				width: 0,
				height: 0,
				position: {
					top: 1e10,
					left: 1e10
				}
			}, i, j, k, l, m;
		while (!g.getBBox) g = g.parentNode;
		if (g.getBBox && g.parentNode) {
			i = g.getBBox(), j = g.getScreenCTM(), k = g.farthestViewportElement || g;
			if (!k.createSVGPoint) return h;
			l = k.createSVGPoint(), l.x = i.x, l.y = i.y, m = l.matrixTransform(j), h.position.left = m.x, h.position.top = m.y, l.x += i.width, l.y += i.height, m = l.matrixTransform(j), h.width = m.x - h.position.left, h.height = m.y - h.position.top, h.position.left += f.scrollLeft(), h.position.top += f.scrollTop()
		}
		return h
	}, r.ajax = function(a) {
		var b = a.plugins.ajax;
		return "object" == typeof b ? b : a.plugins.ajax = new K(a)
	}, r.ajax.initialize = "render", r.ajax.sanitize = function(a) {
		var b = a.content,
			c;
		b && "ajax" in b && (c = b.ajax, typeof c != "object" && (c = a.content.ajax = {
			url: c
		}), "boolean" != typeof c.once && c.once && (c.once = !! c.once))
	}, a.extend(b, q.defaults, {
		content: {
			ajax: {
				loading: b,
				once: b
			}
		}
	}), r.tip = function(a) {
		var b = a.plugins.tip;
		return "object" == typeof b ? b : a.plugins.tip = new M(a)
	}, r.tip.initialize = "render", r.tip.sanitize = function(a) {
		var c = a.style,
			d;
		c && "tip" in c && (d = a.style.tip, typeof d != "object" && (a.style.tip = {
			corner: d
		}), /string|boolean/i.test(typeof d.corner) || (d.corner = b), typeof d.width != "number" && delete d.width, typeof d.height != "number" && delete d.height, typeof d.border != "number" && d.border !== b && delete d.border, typeof d.offset != "number" && delete d.offset)
	}, a.extend(b, q.defaults, {
		style: {
			tip: {
				corner: b,
				mimic: c,
				width: 6,
				height: 6,
				border: b,
				offset: 0
			}
		}
	}), r.modal = function(a) {
		var b = a.plugins.modal;
		return "object" == typeof b ? b : a.plugins.modal = new N(a)
	}, r.modal.initialize = "render", r.modal.sanitize = function(a) {
		a.show && (typeof a.show.modal != "object" ? a.show.modal = {
			on: !! a.show.modal
		} : typeof a.show.modal.on == "undefined" && (a.show.modal.on = b))
	}, r.modal.zindex = q.zindex - 200, r.modal.focusable = ["a[href]", "area[href]", "input", "select", "textarea", "button", "iframe", "object", "embed", "[tabindex]", "[contenteditable]"], a.extend(b, q.defaults, {
		show: {
			modal: {
				on: c,
				effect: b,
				blur: b,
				stealfocus: b,
				escape: b
			}
		}
	}), r.viewport = function(a, b, c, d, n, q, r) {
		function J(a, c, d, e, f, g, h, i, j) {
			var k = b[f],
				l = v[a],
				n = w[a],
				q = d === p,
				r = -C.offset[f] + B.offset[f] + B["scroll" + f],
				s = l === f ? j : l === g ? -j : -j / 2,
				t = n === f ? i : n === g ? -i : -i / 2,
				u = E && E.size ? E.size[h] || 0 : 0,
				x = E && E.corner && E.corner.precedance === a && !q ? u : 0,
				y = r - k + x,
				z = k + j - B[h] - r + x,
				A = s - (v.precedance === a || l === v[c] ? t : 0) - (n === m ? i / 2 : 0);
			return q ? (x = E && E.corner && E.corner.precedance === c ? u : 0, A = (l === f ? 1 : -1) * s - x, b[f] += y > 0 ? y : z > 0 ? -z : 0, b[f] = Math.max(-C.offset[f] + B.offset[f] + (x && E.corner[a] === m ? E.offset : 0), k - A, Math.min(Math.max(-C.offset[f] + B.offset[f] + B[h], k + A), b[f]))) : (e *= d === o ? 2 : 0, y > 0 && (l !== f || z > 0) ? (b[f] -= A + e, H["invert" + a](f)) : z > 0 && (l !== g || y > 0) && (b[f] -= (l === m ? -A : A) + e, H["invert" + a](g)), b[f] < r && -b[f] > z && (b[f] = k, H = undefined)), b[f] - k
		}
		var s = c.target,
			t = a.elements.tooltip,
			v = c.my,
			w = c.at,
			x = c.adjust,
			y = x.method.split(" "),
			z = y[0],
			A = y[1] || y[0],
			B = c.viewport,
			C = c.container,
			D = a.cache,
			E = a.plugins.tip,
			F = {
				left: 0,
				top: 0
			}, G, H, I;
		if (!B.jquery || s[0] === window || s[0] === document.body || x.method === "none") return F;
		G = t.css("position") === "fixed", B = {
			elem: B,
			height: B[(B[0] === window ? "h" : "outerH") + "eight"](),
			width: B[(B[0] === window ? "w" : "outerW") + "idth"](),
			scrollleft: G ? 0 : B.scrollLeft(),
			scrolltop: G ? 0 : B.scrollTop(),
			offset: B.offset() || {
				left: 0,
				top: 0
			}
		}, C = {
			elem: C,
			scrollLeft: C.scrollLeft(),
			scrollTop: C.scrollTop(),
			offset: C.offset() || {
				left: 0,
				top: 0
			}
		};
		if (z !== "shift" || A !== "shift") H = v.clone();
		return F = {
			left: z !== "none" ? J(e, f, z, x.x, j, l, g, d, q) : 0,
			top: A !== "none" ? J(f, e, A, x.y, i, k, h, n, r) : 0
		}, H && D.lastClass !== (I = u + "-pos-" + H.abbrev()) && t.removeClass(a.cache.lastClass).addClass(a.cache.lastClass = I), F
	}, r.imagemap = function(b, c, d, e) {
		function v(a, b, c) {
			var d = 0,
				e = 1,
				f = 1,
				g = 0,
				h = 0,
				n = a.width,
				o = a.height;
			while (n > 0 && o > 0 && e > 0 && f > 0) {
				n = Math.floor(n / 2), o = Math.floor(o / 2), c.x === j ? e = n : c.x === l ? e = a.width - n : e += Math.floor(n / 2), c.y === i ? f = o : c.y === k ? f = a.height - o : f += Math.floor(o / 2), d = b.length;
				while (d--) {
					if (b.length < 2) break;
					g = b[d][0] - a.position.left, h = b[d][1] - a.position.top, (c.x === j && g >= e || c.x === l && g <= e || c.x === m && (g < e || g > a.width - e) || c.y === i && h >= f || c.y === k && h <= f || c.y === m && (h < f || h > a.height - f)) && b.splice(d, 1)
				}
			}
			return {
				left: b[0][0],
				top: b[0][1]
			}
		}
		c.jquery || (c = a(c));
		var f = b.cache.areas = {}, g = (c[0].shape || c.attr("shape")).toLowerCase(),
			h = c[0].coords || c.attr("coords"),
			n = h.split(","),
			o = [],
			p = a('img[usemap="#' + c.parent("map").attr("name") + '"]'),
			q = p.offset(),
			r = {
				width: 0,
				height: 0,
				position: {
					top: 1e10,
					right: 0,
					bottom: 0,
					left: 1e10
				}
			}, s = 0,
			t = 0,
			u;
		q.left += Math.ceil((p.outerWidth() - p.width()) / 2), q.top += Math.ceil((p.outerHeight() - p.height()) / 2);
		if (g === "poly") {
			s = n.length;
			while (s--) t = [parseInt(n[--s], 10), parseInt(n[s + 1], 10)], t[0] > r.position.right && (r.position.right = t[0]), t[0] < r.position.left && (r.position.left = t[0]), t[1] > r.position.bottom && (r.position.bottom = t[1]), t[1] < r.position.top && (r.position.top = t[1]), o.push(t)
		} else {
			s = -1;
			while (s++ < n.length) o.push(parseInt(n[s], 10))
		}
		switch (g) {
			case "rect":
				r = {
					width: Math.abs(o[2] - o[0]),
					height: Math.abs(o[3] - o[1]),
					position: {
						left: Math.min(o[0], o[2]),
						top: Math.min(o[1], o[3])
					}
				};
				break;
			case "circle":
				r = {
					width: o[2] + 2,
					height: o[2] + 2,
					position: {
						left: o[0],
						top: o[1]
					}
				};
				break;
			case "poly":
				r.width = Math.abs(r.position.right - r.position.left), r.height = Math.abs(r.position.bottom - r.position.top), d.abbrev() === "c" ? r.position = {
					left: r.position.left + r.width / 2,
					top: r.position.top + r.height / 2
				} : (f[d + h] || (r.position = v(r, o.slice(), d), e && (e[0] === "flip" || e[1] === "flip") && (r.offset = v(r, o.slice(), {
					x: d.x === j ? l : d.x === l ? j : m,
					y: d.y === i ? k : d.y === k ? i : m
				}), r.offset.left -= r.position.left, r.offset.top -= r.position.top), f[d + h] = r), r = f[d + h]), r.width = r.height = 0
		}
		return r.position.left += q.left, r.position.top += q.top, r
	}, r.bgiframe = function(b) {
		var d = a.browser,
			e = b.plugins.bgiframe;
		return a("select, object").length < 1 || !d.msie || ("" + d.version).charAt(0) !== "6" ? c : "object" == typeof e ? e : b.plugins.bgiframe = new O(b)
	}, r.bgiframe.initialize = "render"
});
(function(e) {
	e.color = {};
	e.color.make = function(c, a, d, f) {
		var b = {};
		b.r = c || 0;
		b.g = a || 0;
		b.b = d || 0;
		b.a = f != null ? f : 1;
		b.add = function(a, c) {
			for (var d = 0; d < a.length; ++d) b[a.charAt(d)] += c;
			return b.normalize()
		};
		b.scale = function(a, d) {
			for (var c = 0; c < a.length; ++c) b[a.charAt(c)] *= d;
			return b.normalize()
		};
		b.toString = function() {
			return b.a >= 1 ? "rgb(" + [b.r, b.g, b.b].join(",") + ")" : "rgba(" + [b.r, b.g, b.b, b.a].join(",") + ")"
		};
		b.normalize = function() {
			function a(b, c, d) {
				return c < b ? b : c > d ? d : c
			}
			b.r = a(0, parseInt(b.r), 255);
			b.g = a(0, parseInt(b.g),
			255);
			b.b = a(0, parseInt(b.b), 255);
			b.a = a(0, b.a, 1);
			return b
		};
		b.clone = function() {
			return e.color.make(b.r, b.b, b.g, b.a)
		};
		return b.normalize()
	};
	e.color.extract = function(c, a) {
		var d;
		do {
			d = c.css(a).toLowerCase();
			if (d != "" && d != "transparent") break;
			c = c.parent()
		} while (!e.nodeName(c.get(0), "body"));
		d == "rgba(0, 0, 0, 0)" && (d = "transparent");
		return e.color.parse(d)
	};
	e.color.parse = function(c) {
		var a, d = e.color.make;
		if (a = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(c)) return d(parseInt(a[1], 10),
		parseInt(a[2], 10), parseInt(a[3], 10));
		if (a = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/.exec(c)) return d(parseInt(a[1], 10), parseInt(a[2], 10), parseInt(a[3], 10), parseFloat(a[4]));
		if (a = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(c)) return d(parseFloat(a[1]) * 2.55, parseFloat(a[2]) * 2.55, parseFloat(a[3]) * 2.55);
		if (a = /rgba\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\s*\)/.exec(c)) return d(parseFloat(a[1]) * 2.55, parseFloat(a[2]) * 2.55, parseFloat(a[3]) * 2.55, parseFloat(a[4]));
		if (a = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(c)) return d(parseInt(a[1], 16), parseInt(a[2], 16), parseInt(a[3], 16));
		if (a = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(c)) return d(parseInt(a[1] + a[1], 16), parseInt(a[2] + a[2], 16), parseInt(a[3] + a[3], 16));
		c = e.trim(c).toLowerCase();
		return c == "transparent" ? d(255, 255, 255, 0) : (a = g[c] || [0, 0, 0], d(a[0], a[1], a[2]))
	};
	var g = {
		aqua: [0, 255, 255],
		azure: [240, 255, 255],
		beige: [245, 245, 220],
		black: [0,
		0, 0],
		blue: [0, 0, 255],
		brown: [165, 42, 42],
		cyan: [0, 255, 255],
		darkblue: [0, 0, 139],
		darkcyan: [0, 139, 139],
		darkgrey: [169, 169, 169],
		darkgreen: [0, 100, 0],
		darkkhaki: [189, 183, 107],
		darkmagenta: [139, 0, 139],
		darkolivegreen: [85, 107, 47],
		darkorange: [255, 140, 0],
		darkorchid: [153, 50, 204],
		darkred: [139, 0, 0],
		darksalmon: [233, 150, 122],
		darkviolet: [148, 0, 211],
		fuchsia: [255, 0, 255],
		gold: [255, 215, 0],
		green: [0, 128, 0],
		indigo: [75, 0, 130],
		khaki: [240, 230, 140],
		lightblue: [173, 216, 230],
		lightcyan: [224, 255, 255],
		lightgreen: [144, 238, 144],
		lightgrey: [211,
		211, 211],
		lightpink: [255, 182, 193],
		lightyellow: [255, 255, 224],
		lime: [0, 255, 0],
		magenta: [255, 0, 255],
		maroon: [128, 0, 0],
		navy: [0, 0, 128],
		olive: [128, 128, 0],
		orange: [255, 165, 0],
		pink: [255, 192, 203],
		purple: [128, 0, 128],
		violet: [128, 0, 128],
		red: [255, 0, 0],
		silver: [192, 192, 192],
		white: [255, 255, 255],
		yellow: [255, 255, 0]
	}
})(jQuery);
(function(a) {
	function r(c, d, b) {
		c.value = a(d).text();
		a(c).change();
		a.browser.msie || c.focus();
		b.hide()
	}
	function n(c, a) {
		var b = c.getHours(),
			h = a.show24Hours ? b : (b + 11) % 12 + 1,
			f = c.getMinutes();
		return (h < 10 ? "0" : "") + h + a.separator + ((f < 10 ? "0" : "") + f) + (a.show24Hours ? "" : b < 12 ? " AM" : " PM")
	}
	function o(c, a) {
		return typeof c == "object" ? p(c) : q(c, a)
	}
	function q(a, d) {
		if (a) {
			var b = a.split(d.separator),
				h = parseFloat(b[0]),
				b = parseFloat(b[1]);
			d.show24Hours || (h === 12 && a.indexOf("AM") !== -1 ? h = 0 : h !== 12 && a.indexOf("PM") !== -1 && (h += 12));
			return p(new Date(0,
			0, 0, h, b, 0))
		}
		return null
	}
	function p(a) {
		a.setFullYear(2001);
		a.setMonth(0);
		a.setDate(0);
		return a
	}
	a.fn.timePicker = function(c) {
		var d = a.extend({}, a.fn.timePicker.defaults, c);
		return this.each(function() {
			a.timePicker(this, d)
		})
	};
	a.timePicker = function(c, d) {
		var b = a(c)[0];
		return b.timePicker || (b.timePicker = new jQuery._timePicker(b, d))
	};
	a.timePicker.version = "0.3";
	a._timePicker = function(c, d) {
		var b = false,
			h = false,
			f = o(d.startTime, d),
			s = o(d.endTime, d);
		a(c).attr("autocomplete", "OFF");
		for (var l = [], j = new Date(f); j <= s;) l[l.length] = n(j, d), j = new Date(j.setMinutes(j.getMinutes() + d.step));
		for (var e = a('<div class="time-picker' + (d.show24Hours ? "" : " time-picker-12hours") + '"></div>'), k = a("<ul></ul>"), j = 0; j < l.length; j++) k.append("<li>" + l[j] + "</li>");
		e.append(k);
		e.appendTo("body").hide();
		e.mouseover(function() {
			b = true
		}).mouseout(function() {
			b = false
		});
		a("li", k).mouseover(function() {
			h || (a("li.selected", e).removeClass("selected"), a(this).addClass("selected"))
		}).mousedown(function() {
			b = true
		}).click(function() {
			r(c, this, e, d);
			b = false
		});
		var m = function() {
			if (e.is(":visible")) return false;
			a("li", e).removeClass("selected");
			var g = a(c).offset();
			e.css({
				top: g.top + c.offsetHeight,
				left: g.left
			});
			e.show();
			var b = c.value ? q(c.value, d) : f,
				g = f.getHours() * 60 + f.getMinutes(),
				b = b.getHours() * 60 + b.getMinutes() - g,
				b = Math.round(b / d.step),
				g = p(new Date(0, 0, 0, 0, b * d.step + g, 0)),
				g = f < g && g <= s ? g : f,
				g = a("li:contains(" + n(g, d) + ")", e);
			if (g.length) g.addClass("selected"), e[0].scrollTop = g[0].offsetTop;
			return true
		};
		a(c).focus(m).click(m);
		a(c).blur(function() {
			b || e.hide()
		});
		l = a.browser.opera || a.browser.mozilla ? "keypress" : "keydown";
		a(c)[l](function(b) {
			h = true;
			var f = e[0].scrollTop;
			switch (b.keyCode) {
				case 38:
					if (m()) return false;
					var b = a("li.selected", k),
						i = b.prev().addClass("selected")[0];
					if (i) {
						if (b.removeClass("selected"), i.offsetTop < f) e[0].scrollTop = f - i.offsetHeight
					} else b.removeClass("selected"), i = a("li:last", k).addClass("selected")[0], e[0].scrollTop = i.offsetTop - i.offsetHeight;
					return false;
				case 40:
					if (m()) return false;
					b = a("li.selected", k);
					if (i = b.next().addClass("selected")[0]) {
						if (b.removeClass("selected"), i.offsetTop + i.offsetHeight > f + e[0].offsetHeight) e[0].scrollTop = f + i.offsetHeight
					} else b.removeClass("selected"), a("li:first", k).addClass("selected"), e[0].scrollTop = 0;
					return false;
				case 13:
					return e.is(":visible") && (f = a("li.selected", k)[0], r(c, f, e, d)), false;
				case 27:
					return e.hide(), false
			}
			return true
		});
		a(c).keyup(function() {
			h = false
		});
		this.getTime = function() {
			return q(c.value, d)
		};
		this.setTime = function(b) {
			c.value = n(o(b, d), d);
			a(c).change()
		}
	};
	a.fn.timePicker.defaults = {
		step: 30,
		startTime: new Date(0, 0, 0, 0, 0, 0),
		endTime: new Date(0, 0, 0, 23, 30,
		0),
		separator: ":",
		show24Hours: true
	}
})(jQuery);
(function(g) {
	g.cookie = function(h, b, a) {
		if (arguments.length > 1 && (!/Object/.test(Object.prototype.toString.call(b)) || b === null || b === void 0)) {
			a = g.extend({}, a);
			if (b === null || b === void 0) a.expires = -1;
			if (typeof a.expires === "number") {
				var d = a.expires,
					c = a.expires = new Date;
				c.setDate(c.getDate() + d)
			}
			b = String(b);
			return document.cookie = [encodeURIComponent(h), "=", a.raw ? b : encodeURIComponent(b), a.expires ? "; expires=" + a.expires.toUTCString() : "", a.path ? "; path=" + a.path : "", a.domain ? "; domain=" + a.domain : "", a.secure ? "; secure" :
				""].join("")
		}
		for (var a = b || {}, d = a.raw ? function(a) {
				return a
			} : decodeURIComponent, c = document.cookie.split("; "), e = 0, f; f = c[e] && c[e].split("="); e++) if (d(f[0]) === h) return d(f[1] || "");
		return null
	}
})(jQuery);
$.fn.serializeObject = function() {
	var a = {}, b = this.find(":input").serializeArray();
	$.each(b, function() {
		if (this.value == "true") this.value = true;
		else if (this.value == "false") this.value = false;
		else if (this.value === void 0) this.value = "";
		a[this.name] !== void 0 ? (a[this.name].push || (a[this.name] = [a[this.name]]), a[this.name].push(this.value)) : a[this.name] = this.value
	});
	return a
};

function load_i18n_strings() {
	AgenDAVConf.i18n = {};
	var a = $.ajax({
		async: false,
		url: base_app_url + "strings/load/" + agendav_version,
		dataType: "json",
		method: "GET",
		ifModified: false
	});
	a.done(function(a) {
		AgenDAVConf.i18n = a;
		set_default_datepicker_options()
	});
	a.fail(function() {
		show_error("Error loading translation", "Please, contact your system administrator")
	})
}

function t(a, c, d) {
	var b = "[" + a + ":" + c + "]";
	if (typeof AgenDAVConf.i18n != "undefined" && (a == "messages" || a == "labels")) a == "labels" && AgenDAVConf.i18n.labels[c] ? b = AgenDAVConf.i18n.labels[c] : a == "messages" && AgenDAVConf.i18n.messages[c] && (b = AgenDAVConf.i18n.messages[c]);
	for (var e in d) b = b.replace(e, d[e]);
	return b
}
function labels_as_array(a) {
	if (!$.isArray(a)) return [];
	for (var c = [], d = a.length, b = 0; b < d; b++) c.push(AgenDAVConf.i18n.labels[a[b]]);
	return c
}

function month_names_long() {
	return labels_as_array("january,february,march,april,may,june,july,august,september,october,november,december".split(","))
}
function month_names_short() {
	return labels_as_array("january_short,february_short,march_short,april_short,may_short,june_short,july_short,august,september_short,october_short,november_short,december_short".split(","))
}
function day_names_long() {
	return labels_as_array("sunday,monday,tuesday,wednesday,thursday,friday,saturday".split(","))
}

function day_names_short() {
	return labels_as_array("sunday_short,monday_short,tuesday_short,wednesday_short,thursday_short,friday_short,saturday_short".split(","))
};
var dust = {};

function getGlobal() {
	return function() {
		return this.dust
	}.call(null)
}
(function(e) {
	function i(a, c, f) {
		this.stack = a;
		this.global = c;
		this.blocks = f
	}
	function j(a, c, f, b) {
		this.tail = c;
		this.isObject = !e.isArray(a) && a && typeof a === "object";
		this.head = a;
		this.index = f;
		this.of = b
	}
	function l(a) {
		this.head = new h(this);
		this.callback = a;
		this.out = ""
	}
	function k() {
		this.head = new h(this)
	}
	function h(a, c, f) {
		this.root = a;
		this.next = c;
		this.data = "";
		this.flushable = false;
		this.taps = f
	}
	function b(a, c) {
		this.head = a;
		this.tail = c
	}
	e.cache = {};
	e.register = function(a, c) {
		a && (e.cache[a] = c)
	};
	e.render = function(a, c, f) {
		f = (new l(f)).head;
		e.load(a, f, i.wrap(c)).end()
	};
	e.stream = function(a, c) {
		var f = new k;
		e.nextTick(function() {
			e.load(a, f.head, i.wrap(c)).end()
		});
		return f
	};
	e.renderSource = function(a, c, f) {
		return e.compileFn(a)(c, f)
	};
	e.compileFn = function(a, c) {
		var f = e.loadSource(e.compile(a, c));
		return function(a, c) {
			var b = c ? new l(c) : new k;
			e.nextTick(function() {
				f(b.head, i.wrap(a)).end()
			});
			return b
		}
	};
	e.load = function(a, c, f) {
		var b = e.cache[a];
		return b ? b(c, f) : e.onLoad ? c.map(function(c) {
			e.onLoad(a, function(b, d) {
				if (b) return c.setError(b);
				e.cache[a] || e.loadSource(e.compile(d, a));
				e.cache[a](c, f).end()
			})
		}) : c.setError(Error("Template Not Found: " + a))
	};
	e.loadSource = function(a) {
		return eval(a)
	};
	e.isArray = Array.isArray ? Array.isArray : function(a) {
		return Object.prototype.toString.call(a) == "[object Array]"
	};
	e.nextTick = function() {
		return typeof process !== "undefined" ? process.nextTick : function(a) {
			setTimeout(a, 0)
		}
	}();
	e.isEmpty = function(a) {
		return e.isArray(a) && !a.length ? true : a === 0 ? false : !a
	};
	e.filter = function(a, c, f) {
		if (f) for (var b = 0, d = f.length; b < d; b++) {
			var g = f[b];
			g === "s" ? c = null : a = e.filters[g](a)
		}
		c && (a = e.filters[c](a));
		return a
	};
	e.filters = {
		h: function(a) {
			return e.escapeHtml(a)
		},
		j: function(a) {
			return e.escapeJs(a)
		},
		u: encodeURI,
		uc: encodeURIComponent,
		js: function(a) {
			return !JSON ? a : JSON.stringify(a)
		},
		jp: function(a) {
			return !JSON ? a : JSON.parse(a)
		}
	};
	e.makeBase = function(a) {
		return new i(new j, a)
	};
	i.wrap = function(a) {
		return a instanceof i ? a : new i(new j(a))
	};
	i.prototype.get = function(a) {
		for (var c = this.stack, f; c;) {
			if (c.isObject && (f = c.head[a], f !== void 0)) return f;
			c = c.tail
		}
		return this.global ? this.global[a] : void 0
	};
	i.prototype.getPath = function(a, c) {
		var f = this.stack,
			b = c.length;
		if (a && b === 0) return f.head;
		if (f.isObject) {
			for (var f = f.head, d = 0; f && d < b;) f = f[c[d]], d++;
			return f
		}
	};
	i.prototype.push = function(a, c, f) {
		if (a) a.$idx = c, a.$len = f;
		return new i(new j(a, this.stack, c, f), this.global, this.blocks)
	};
	i.prototype.rebase = function(a) {
		return new i(new j(a), this.global, this.blocks)
	};
	i.prototype.current = function() {
		return this.stack.head
	};
	i.prototype.getBlock = function(a, c, f) {
		if (typeof a === "function") a = a(c,
		f).data, c.data = "";
		if (c = this.blocks) for (var f = c.length, b; f--;) if (b = c[f][a]) return b
	};
	i.prototype.shiftBlocks = function(a) {
		var c = this.blocks;
		return a ? (newBlocks = c ? c.concat([a]) : [a], new i(this.stack, this.global, newBlocks)) : this
	};
	l.prototype.flush = function() {
		for (var a = this.head; a;) {
			if (a.flushable) this.out += a.data;
			else {
				if (a.error) this.callback(a.error), this.flush = function() {};
				return
			}
			this.head = a = a.next
		}
		this.callback(null, this.out)
	};
	k.prototype.flush = function() {
		for (var a = this.head; a;) {
			if (a.flushable) this.emit("data",
			a.data);
			else {
				if (a.error) this.emit("error", a.error), this.flush = function() {};
				return
			}
			this.head = a = a.next
		}
		this.emit("end")
	};
	k.prototype.emit = function(a, c) {
		var f = this.events;
		if (f && f[a]) f[a](c)
	};
	k.prototype.on = function(a, c) {
		if (!this.events) this.events = {};
		this.events[a] = c;
		return this
	};
	k.prototype.pipe = function(a) {
		this.on("data", function(c) {
			a.write(c, "utf8")
		}).on("end", function() {
			a.end()
		}).on("error", function(c) {
			a.error(c)
		});
		return this
	};
	h.prototype.write = function(a) {
		var c = this.taps;
		c && (a = c.go(a));
		this.data += a;
		return this
	};
	h.prototype.end = function(a) {
		a && this.write(a);
		this.flushable = true;
		this.root.flush();
		return this
	};
	h.prototype.map = function(a) {
		var c = new h(this.root, this.next, this.taps),
			f = new h(this.root, c, this.taps);
		this.next = f;
		this.flushable = true;
		a(f);
		return c
	};
	h.prototype.tap = function(a) {
		var c = this.taps;
		this.taps = c ? c.push(a) : new b(a);
		return this
	};
	h.prototype.untap = function() {
		this.taps = this.taps.tail;
		return this
	};
	h.prototype.render = function(a, c) {
		return a(this, c)
	};
	h.prototype.reference = function(a, c,
	f, b) {
		return typeof a === "function" && (a = a(this, c, null, {
			auto: f,
			filters: b
		}), a instanceof h) ? a : e.isEmpty(a) ? this : this.write(e.filter(a, f, b))
	};
	h.prototype.section = function(a, c, f, b) {
		if (typeof a === "function" && (a = a(this, c, f, b), a instanceof h)) return a;
		var d = f.block,
			f = f["else"];
		b && (c = c.push(b));
		if (e.isArray(a)) {
			if (d) {
				for (var b = a.length, f = this, g = 0; g < b; g++) f = d(f, c.push(a[g], g, b));
				return f
			}
		} else if (a === true) {
			if (d) return d(this, c)
		} else if (a || a === 0) {
			if (d) return d(this, c.push(a))
		} else if (f) return f(this, c);
		return this
	};
	h.prototype.exists = function(a, c, f) {
		var b = f.block,
			f = f["else"];
		if (e.isEmpty(a)) {
			if (f) return f(this, c)
		} else if (b) return b(this, c);
		return this
	};
	h.prototype.notexists = function(a, c, b) {
		var d = b.block,
			b = b["else"];
		if (e.isEmpty(a)) {
			if (d) return d(this, c)
		} else if (b) return b(this, c);
		return this
	};
	h.prototype.block = function(a, c, b) {
		b = b.block;
		a && (b = a);
		return b ? b(this, c) : this
	};
	h.prototype.partial = function(a, c, b) {
		var d = c.stack,
			g = d.head;
		b && (c = c.rebase(d.tail), c = c.push(b), c = c.push(g));
		return typeof a === "function" ? this.capture(a,
		c, function(a, b) {
			e.load(a, b, c).end()
		}) : e.load(a, this, c)
	};
	h.prototype.helper = function(a, c, b, d) {
		return e.helpers[a](this, c, b, d)
	};
	h.prototype.capture = function(a, b, f) {
		return this.map(function(d) {
			var g = new l(function(a, b) {
				a ? d.setError(a) : f(b, d)
			});
			a(g.head, b).end()
		})
	};
	h.prototype.setError = function(a) {
		this.error = a;
		this.root.flush();
		return this
	};
	b.prototype.push = function(a) {
		return new b(a, this)
	};
	b.prototype.go = function(a) {
		for (var b = this; b;) a = b.head(a), b = b.tail;
		return a
	};
	var d = RegExp(/[&<>\"\']/),
		o = /&/g,
		g =
			/</g,
		n = />/g,
		m = /\"/g,
		p = /\'/g;
	e.escapeHtml = function(a) {
		return typeof a === "string" ? !d.test(a) ? a : a.replace(o, "&amp;").replace(g, "&lt;").replace(n, "&gt;").replace(m, "&quot;").replace(p, "&#39;") : a
	};
	var q = /\\/g,
		r = /\r/g,
		s = /\u2028/g,
		t = /\u2029/g,
		u = /\n/g,
		v = /\f/g,
		w = /'/g,
		x = /"/g,
		y = /\t/g;
	e.escapeJs = function(a) {
		return typeof a === "string" ? a.replace(q, "\\\\").replace(x, '\\"').replace(w, "\\'").replace(r, "\\r").replace(s, "\\u2028").replace(t, "\\u2029").replace(u, "\\n").replace(v, "\\f").replace(y, "\\t") : a
	}
})(dust);
if (typeof exports !== "undefined") dust.helpers = require("../dust-helpers/lib/dust-helpers").helpers, typeof process !== "undefined" && require("./server")(dust), module.exports = dust;
(function(e) {
	function i(b) {
		b = b.current();
		return typeof b === "object" && b.isSelect === true
	}
	function j(b, d, e, g, n) {
		var g = g || {}, m, j;
		if (g.key) m = h.tap(g.key, b, d);
		else if (i(d)) m = d.current().selectKey, d.current().isResolved && (n = function() {
			return false
		});
		else throw "No key specified for filter and no key found in context from select statement";
		j = h.tap(g.value, b, d);
		if (n(j, l(m, g.type, d))) {
			if (i(d)) d.current().isResolved = true;
			return b.render(e.block, d)
		} else if (e["else"]) return b.render(e["else"], d);
		return b.write("")
	}

	function l(b, d, e) {
		if (b) switch (d || typeof b) {
			case "number":
				return +b;
			case "string":
				return String(b);
			case "boolean":
				return Boolean(b);
			case "date":
				return new Date(b);
			case "context":
				return e.get(b)
		}
		return b
	}
	var k = typeof console !== "undefined" ? console : {
		log: function() {}
	}, h = {
		sep: function(b, d, e) {
			return d.stack.index === d.stack.of - 1 ? b : e.block(b, d)
		},
		idx: function(b, d, e) {
			return e.block(b, d.push(d.stack.index))
		},
		contextDump: function(b, d) {
			k.log(JSON.stringify(d.stack));
			return b
		},
		tap: function(b, d, e) {
			var g = b;
			typeof b ===
				"function" && (g = "", d.tap(function(b) {
				g += b;
				return ""
			}).render(b, e).untap(), g === "" && (g = false));
			return g
		},
		"if": function(b, d, e, g) {
			if (g && g.cond) {
				g = g.cond;
				g = this.tap(g, b, d);
				if (eval(g)) return b.render(e.block, d);
				if (e["else"]) return b.render(e["else"], d)
			} else k.log("No condition given in the if helper!");
			return b
		},
		select: function(b, d, e, g) {
			if (g && g.key) return g = this.tap(g.key, b, d), b.render(e.block, d.push({
				isSelect: true,
				isResolved: false,
				selectKey: g
			}));
			else k.log("No key given in the select helper!");
			return b
		},
		eq: function(b, d, e, g) {
			return j(b, d, e, g, function(b, d) {
				return d === b
			})
		},
		lt: function(b, d, e, g) {
			return j(b, d, e, g, function(b, d) {
				return d < b
			})
		},
		lte: function(b, d, e, g) {
			return j(b, d, e, g, function(b, d) {
				return d <= b
			})
		},
		gt: function(b, d, e, g) {
			return j(b, d, e, g, function(b, d) {
				return d > b
			})
		},
		gte: function(b, d, e, g) {
			return j(b, d, e, g, function(b, d) {
				return d >= b
			})
		},
		"default": function(b, d, e, g) {
			return j(b, d, e, g, function() {
				return true
			})
		}
	};
	e.helpers = h
})(typeof exports !== "undefined" ? exports : getGlobal());
(function() {
	function a(b, a) {
		return b.write('<form action="').reference(a.getPath(false, ["frm", "action"]), a, "h").write('" method="').reference(a.getPath(false, ["frm", "method"]), a, "h").write('"').exists(a.get("applyclass"), a, {
			block: e
		}, null).exists(a.get("applyid"), a, {
			block: d
		}, null).write(' accept-charset="utf-8"><input type="hidden" name="').reference(a.get("csrf_token_name"), a, "h").write('" value="').reference(a.getPath(false, ["frm", "csrf"]), a, "h").write('" />')
	}
	function e(b, a) {
		return b.write('class="').reference(a.get("applyclass"),
		a, "h").write('"')
	}
	function d(b, a) {
		return b.write(' id="').reference(a.get("applyid"), a, "h").write('"')
	}
	dust.register("form_open", a);
	return a
})();
(function() {
	function a(a, h) {
		return a.write(' <option value="0"').helper("eq", h, {
			block: e
		}, {
			key: d,
			value: "0"
		}).write(">").helper("i18n", h, {}, {
			type: "labels",
			name: "readonly"
		}).write('</option><option value="1"').helper("eq", h, {
			block: b
		}, {
			key: f,
			value: "1"
		}).write(">").helper("i18n", h, {}, {
			type: "labels",
			name: "readandwrite"
		}).write("</option>")
	}
	function e(a) {
		return a.write(' selected="true"')
	}
	function d(a, b) {
		return a.reference(b.get("write_access"), b, "h")
	}
	function b(a) {
		return a.write(' selected="true"')
	}
	function f(a,
	b) {
		return a.reference(b.get("write_access"), b, "h")
	}
	dust.register("calendar_share_access_options", a);
	return a
})();
(function() {
	function a(a, d) {
		return a.write('<div id="calendar_create_dialog">').partial("form_open", d, {
			applyclass: "form-horizontal",
			applyid: "calendar_create_form"
		}).partial("calendar_basic_form_part", d, null).partial("form_close", d, null).write("</div>")
	}
	dust.register("calendar_create_dialog", a);
	return a
})();
(function() {
	function a(a) {
		return a.write("</form>")
	}
	dust.register("form_close", a);
	return a
})();
(function() {
	function a(a, d) {
		return a.write('<div id="calendar_delete_dialog">').partial("form_open", d, null).write('<input type="hidden" name="calendar" value="').reference(d.get("calendar"), d, "h").write('" /><p>').helper("i18n", d, {}, {
			type: "messages",
			name: "info_confirmcaldelete"
		}).write('</p><p><div class="calendar_color" style="background-color: ').reference(d.get("color"), d, "h").write(';"></div> ').reference(d.get("displayname"), d, "h").write("</p><p>").helper("i18n", d, {}, {
			type: "messages",
			name: "info_permanentremoval"
		}).write("</p>").partial("form_close",
		d, null).write("</div>")
	}
	dust.register("calendar_delete_dialog", a);
	return a
})();
(function() {
	function a(a, f) {
		return a.section(f.get("visible_reminders"), f, {
			block: e
		}, null).write('<table id="reminders_table" class="table table-striped"><thead><th></th><th></th><th></th></thead><tbody>').section(f.get("reminders"), f, {
			block: d
		}, null).write('<tr id="reminders_no_rows"><td colspan="3">').helper("i18n", f, {}, {
			type: "messages",
			name: "info_noreminders"
		}).write('</td></tr></tbody></table><span class="table_title">').helper("i18n", f, {}, {
			type: "labels",
			name: "newreminder"
		}).write('</span><table class="table"><tbody>').partial("reminder_row",
		f, {
			add: "true"
		}).write('</tbody></table><span class="table_title">').helper("i18n", f, {}, {
			type: "labels",
			name: "newreminder"
		}).write('</span><table class="table"><tbody>').partial("reminder_row", f, {
			add: "true",
			is_absolute: "true"
		}).write("</tbody></table>")
	}
	function e(a, d) {
		return a.write('<input type="hidden" name="visible_reminders[').reference(d.getPath(true, []), d, "h").write(']" value="1" />')
	}
	function d(a, d) {
		return a.partial("reminder_row", d, null)
	}
	dust.register("reminders_table", a);
	return a
})();
(function() {
	function a(a, b) {
		return a.write('<table id="calendar_share_table" class="table table-striped"><thead><th>').helper("i18n", b, {}, {
			type: "labels",
			name: "username"
		}).write("</th><th>").helper("i18n", b, {}, {
			type: "labels",
			name: "access"
		}).write("</th><th></th></thead><tbody>").section(b.get("share_with"), b, {
			block: e
		}, null).write('<tr id="calendar_share_no_rows"><td colspan="3">').helper("i18n", b, {}, {
			type: "messages",
			name: "info_notshared"
		}).write('</td></tr></tbody></table><span class="table_title">').helper("i18n",
		b, {}, {
			type: "labels",
			name: "sharewith"
		}).write('</span><table id="calendar_share_add" class="table-condensed"><tbody><tr><td><div class="username"><input name="autocomplete_username"class="input-medium" id="calendar_share_add_username"value="" maxlength="255" size="10" /></div></td><td><select name="write-access" id="calendar_share_add_write_access"class="input-medium">').partial("calendar_share_access_options", b, null).write('</select></td><td><img src="').reference(b.get("base_url"), b, "h").write('img/add.png" id="calendar_share_add_button"class="pseudobutton"alt="').helper("i18n",
		b, {}, {
			type: "labels",
			name: "add"
		}).write('title="').helper("i18n", b, {}, {
			type: "labels",
			name: "add"
		}).write(" /></td></tr></tbody></table>")
	}
	function e(a, b) {
		return a.partial("calendar_share_row", b, null)
	}
	dust.register("calendar_share_table", a);
	return a
})();
(function() {
	function a(a, c) {
		return a.write('<p class="start_and_finish">').reference(c.get("formatted_start"), c, "h").write(" ").reference(c.get("formatted_end"), c, "h").write('</p><dl class="dl-horizontal"><dt>').helper("i18n", c, {}, {
			type: "labels",
			name: "calendar"
		}).write('</dt><dd><div class="calendar_color" style="background-color: ').reference(c.getPath(false, ["caldata", "color"]), c, "h").write(';"></div>').reference(c.getPath(false, ["caldata", "displayname"]), c, "h").write("</dd>").exists(c.get("location"),
		c, {
			block: e
		}, null).exists(c.get("description"), c, {
			block: d
		}, null).exists(c.get("rrule"), c, {
			block: b
		}, null).section(c.get("reminders"), c, {
			block: k
		}, null).notexists(c.get("disable_actions"), c, {
			block: l
		}, null).write("</dl>")
	}
	function e(a, c) {
		return a.write("<dt>").helper("i18n", c, {}, {
			type: "labels",
			name: "location"
		}).write("</dt><dd>").reference(c.get("location"), c, "h").write("</dd>")
	}
	function d(a, c) {
		return a.write("<dt>").helper("i18n", c, {}, {
			type: "labels",
			name: "description"
		}).write("</dt><dd>").reference(c.get("formatted_description"),
		c, "h").write("</dd>")
	}
	function b(a, c) {
		return a.write("<dt>").helper("i18n", c, {}, {
			type: "labels",
			name: "repeat"
		}).write("</dt>").exists(c.get("rrule_explained"), c, {
			"else": f,
			block: j
		}, null)
	}
	function f(a, c) {
		return a.write("<dd>").helper("i18n", c, {}, {
			type: "messages",
			name: "info_repetition_unparseable"
		}).write(' <spanclass="rrule_raw_value">').reference(c.get("rrule"), c, "h").write("</span></dd>")
	}
	function j(a, c) {
		return a.write("<dd>").helper("i18n", c, {}, {
			type: "messages",
			name: "info_repetition_human",
			explanation: h
		}).write("</dd>")
	}

	function h(a, c) {
		return a.reference(c.get("rrule_explained"), c, "h")
	}
	function k(a, c) {
		return a.write("<dt>").helper("i18n", c, {}, {
			type: "labels",
			name: "reminder"
		}).write("</dt><dd>").partial("reminder_description", c, null).write("</dd>")
	}
	function l(a, c) {
		return a.write('<div class="actions"><button type="button" href="#"class="addicon btn-icon-calendar-edit link_modify_event">').helper("i18n", c, {}, {
			type: "labels",
			name: "modify"
		}).write('</button><button type="button" href="#"class="addicon btn-icon-calendar-delete link_delete_event">').helper("i18n",
		c, {}, {
			type: "labels",
			name: "delete"
		}).write("</button></div>")
	}
	dust.register("event_details_popup", a);
	return a
})();
(function() {
	function a(a, d) {
		return a.write('<span class="fc-header-space" /><span class="fc-button-datepicker"><i class="icon-calendar" title="').helper("i18n", d, {}, {
			type: "labels",
			name: "choose_date"
		}).write('"></i></span><input type="hidden" id="datepicker_fullcalendar" />')
	}
	dust.register("datepicker_button", a);
	return a
})();
(function() {
	function a(a, c) {
		return a.write('<div id="calendar_modify_dialog"><div id="calendar_modify_dialog_tabs"><ul><li><a href="#tabs-general"><i class="tab-icon icon-tag"></i>').helper("i18n", c, {}, {
			type: "labels",
			name: "generaloptions"
		}).write("</a></li>").exists(c.get("enable_calendar_sharing"), c, {
			block: e
		}, null).write("</ul>").partial("form_open", c, {
			applyclass: "form-horizontal",
			applyid: "calendar_modify_form"
		}).write('<div id="tabs-general">').exists(c.get("user_from"), c, {
			block: b
		}, null).partial("calendar_basic_form_part",
		c, null).write("</div>").exists(c.get("enable_calendar_sharing"), c, {
			block: k
		}, null).partial("form_close", c, null).write("</div>")
	}
	function e(a, c) {
		return a.notexists(c.get("shared"), c, {
			block: d
		}, null)
	}
	function d(a, c) {
		return a.write('<li><a href="#tabs-share"><i class="tab-icon icon-group"></i>').helper("i18n", c, {}, {
			type: "labels",
			name: "shareoptions"
		}).write("</a></li>")
	}
	function b(a, c) {
		return a.write('<div class="share_info ui-corner-all">').helper("i18n", c, {}, {
			type: "messages",
			name: "info_sharedby",
			user: f
		}).write(" ").helper("eq",
		c, {
			block: j
		}, {
			key: h,
			value: "0"
		}).write("</div>")
	}
	function f(a, c) {
		return a.reference(c.get("user_from"), c, "h")
	}
	function j(a, c) {
		return a.write("(").helper("i18n", c, {}, {
			type: "labels",
			name: "readonly"
		}).write(")")
	}
	function h(a, c) {
		return a.reference(c.get("write_access"), c, "h")
	}
	function k(a, c) {
		return a.notexists(c.get("shared"), c, {
			block: l
		}, null)
	}
	function l(a, c) {
		return a.write('<div id="tabs-share">').partial("calendar_share_table", c, null).write("</div>")
	}
	dust.register("calendar_modify_dialog", a);
	return a
})();
(function() {
	function a(a, g) {
		return a.exists(g.get("calendar"), g, {
			block: e
		}, null).write('<input type="hidden" name="is_shared_calendar"value="').exists(g.get("shared"), g, {
			"else": d,
			block: b
		}, null).write('" />').partial("form_element_start", g, {
			"for": "displayname",
			label: "displayname"
		}).write('<input name="displayname" type="text" size="25" maxlength="255" value="').exists(g.get("displayname"), g, {
			block: f
		}, null).write('" class="displayname input-medium" />').partial("form_element_end", g, null).partial("form_element_start",
		g, {
			"for": "color",
			label: "color"
		}).write('<input name="calendar_color"value="').exists(g.get("color"), g, {
			"else": j,
			block: h
		}, null).write('" class="calendar_color pick_color input-mini" maxlength="7" size="7" />').partial("form_element_end", g, null).exists(g.get("public_url"), g, {
			block: k
		}, null)
	}
	function e(a, b) {
		return a.write('<input type="hidden" name="calendar" value="').reference(b.get("calendar"), b, "h").write('" />')
	}
	function d(a) {
		return a.write("false")
	}
	function b(a) {
		return a.write("true")
	}
	function f(a,
	b) {
		return a.reference(b.get("displayname"), b, "h")
	}
	function j(a, b) {
		return a.reference(b.get("default_calendar_color"), b, "h")
	}
	function h(a, b) {
		return a.reference(b.get("color"), b, "h")
	}
	function k(a, b) {
		return a.write('<div class="public_url_container"><i class="icon-link icon-large"></i> <a href="').reference(b.get("public_url"), b, "h").write('">').helper("i18n", b, {}, {
			type: "labels",
			name: "publicurl"
		}).write("</p></a></div>")
	}
	dust.register("calendar_basic_form_part", a);
	return a
})();
(function() {
	function a(a, b) {
		return a.write('<div class="control-group"><label ').exists(b.get("for"), b, {
			block: e
		}, null).write('class="control-label">').helper("i18n", b, {}, {
			type: "labels",
			name: b.get("label")
		}).write('</label><div class="controls">')
	}
	function e(a, b) {
		return a.write('for="').reference(b.get("for"), b, "h").write('"')
	}
	dust.register("form_element_start", a);
	return a
})();
(function() {
	function a(a, d) {
		return a.write('<tr><td><span class="username">').reference(d.get("username"), d, "h").write('</span></td><td><input type="hidden" name="share_with[sid][]" value="').reference(d.get("sid"), d, "h").write('"/><input type="hidden" name="share_with[username][]" value="').reference(d.get("username"), d, "h").write('"/><select name="share_with[write_access][]" class="input-medium">').partial("calendar_share_access_options", d, null).write('</select></td><td><img src="').reference(d.get("base_url"),
		d, "h").write('img/delete.png" class="calendar_share_delete pseudobutton" alt="').helper("i18n", d, {}, {
			type: "labels",
			name: "delete"
		}).write('"title="').helper("i18n", d, {}, {
			type: "labels",
			name: "delete"
		}).write('" /></td></tr>')
	}
	dust.register("calendar_share_row", a);
	return a
})();
(function() {
	function a(a, b) {
		return a.exists(b.get("input_help"), b, {
			block: e
		}, null).write("</div></div>")
	}
	function e(a, b) {
		return a.write('<p class="help-block">').reference(b.get("input_help"), b, "h").write("</p>")
	}
	dust.register("form_element_end", a);
	return a
})();
(function() {
	function a(a, i) {
		return a.write('<tr><td><input type="hidden" name="').notexists(i.get("add"), i, {
			"else": e,
			block: d
		}, null).write('" value="').exists(i.get("is_absolute"), i, {
			"else": b,
			block: f
		}, null).write('" />').notexists(i.get("add"), i, {
			block: j
		}, null).exists(i.get("is_absolute"), i, {
			"else": h,
			block: k
		}, null).write('</td><td class="form-inline">').exists(i.get("is_absolute"), i, {
			"else": l,
			block: o
		}, null).write("</td><td>").exists(i.get("add"), i, {
			"else": p,
			block: q
		}, null).write("</td></tr>")
	}
	function e(a) {
		return a.write("is_absolute")
	}

	function d(a) {
		return a.write("reminders[is_absolute][]")
	}
	function b(a) {
		return a.write("false")
	}
	function f(a) {
		return a.write("true")
	}
	function j(a, b) {
		return a.write('<input type="hidden" name="reminders[order][]" value="').reference(b.get("order"), b, "h").write('" />')
	}
	function h(a) {
		return a.write('<i class="icon-time icon-large"></i>')
	}
	function k(a) {
		return a.write('<i class="icon-calendar icon-large"></i>')
	}
	function l(a, b) {
		return a.write('<input name="').notexists(b.get("add"), b, {
			"else": g,
			block: c
		},
		null).write('" class="input-mini" maxlength="4" value="').reference(b.get("qty"), b, "h").write('" /><select class="input-small" name="').notexists(b.get("add"), b, {
			"else": m,
			block: n
		}, null).write('"><option value="min"').helper("eq", b, {
			block: r
		}, {
			key: s,
			value: "min"
		}).write(">").helper("i18n", b, {}, {
			type: "labels",
			name: "minutes"
		}).write('</option><option value="hour"').helper("eq", b, {
			block: t
		}, {
			key: u,
			value: "hour"
		}).write(">").helper("i18n", b, {}, {
			type: "labels",
			name: "hours"
		}).write('</option><option value="day"').helper("eq",
		b, {
			block: v
		}, {
			key: w,
			value: "day"
		}).write(">").helper("i18n", b, {}, {
			type: "labels",
			name: "days"
		}).write('</option><option value="week"').helper("eq", b, {
			block: x
		}, {
			key: y,
			value: "week"
		}).write(">").helper("i18n", b, {}, {
			type: "labels",
			name: "weeks"
		}).write('</option></select><select class="input-small" name="').notexists(b.get("add"), b, {
			"else": z,
			block: A
		}, null).write('"><option value="true"').exists(b.get("before"), b, {
			block: B
		}, null).write(">").helper("i18n", b, {}, {
			type: "labels",
			name: "before"
		}).write('</option><option value="false"').notexists(b.get("before"),
		b, {
			block: C
		}, null).write(">").helper("i18n", b, {}, {
			type: "labels",
			name: "after"
		}).write('</option></select><select class="input-small" name="').notexists(b.get("add"), b, {
			"else": D,
			block: E
		}, null).write('"><option value="true"').exists(b.get("relatedStart"), b, {
			block: F
		}, null).write(">").helper("i18n", b, {}, {
			type: "labels",
			name: "start"
		}).write('</option><option value="false"').notexists(b.get("relatedStart"), b, {
			block: G
		}, null).write(">").helper("i18n", b, {}, {
			type: "labels",
			name: "end"
		}).write("</option></select>").notexists(b.get("add"),
		b, {
			block: H
		}, null)
	}
	function g(a) {
		return a.write("qty")
	}
	function c(a) {
		return a.write("reminders[qty][]")
	}
	function m(a) {
		return a.write("interval")
	}
	function n(a) {
		return a.write("reminders[interval][]")
	}
	function r(a) {
		return a.write(' selected="true"')
	}
	function s(a, b) {
		return a.reference(b.get("interval"), b, "h")
	}
	function t(a) {
		return a.write(' selected="true"')
	}
	function u(a, b) {
		return a.reference(b.get("interval"), b, "h")
	}
	function v(a) {
		return a.write(' selected="true"')
	}
	function w(a, b) {
		return a.reference(b.get("interval"),
		b, "h")
	}
	function x(a) {
		return a.write(' selected="true"')
	}
	function y(a, b) {
		return a.reference(b.get("interval"), b, "h")
	}
	function z(a) {
		return a.write("before")
	}
	function A(a) {
		return a.write("reminders[before][]")
	}
	function B(a) {
		return a.write(' selected="true"')
	}
	function C(a, b) {
		return a.notexists(b.get("add"), b, {
			block: I
		}, null)
	}
	function I(a) {
		return a.write(' selected="true"')
	}
	function D(a) {
		return a.write("relatedStart")
	}
	function E(a) {
		return a.write("reminders[relatedStart][]")
	}
	function F(a) {
		return a.write(' selected="true"')
	}

	function G(a, b) {
		return a.notexists(b.get("add"), b, {
			block: J
		}, null)
	}
	function J(a) {
		return a.write(' selected="true"')
	}
	function H(a) {
		return a.write('<input type="hidden" name="reminders[tdate][]" value="" /><input type="hidden" name="reminders[ttime][]" value="" />')
	}
	function o(a, b) {
		return a.write('<input type="text" name="').notexists(b.get("add"), b, {
			"else": K,
			block: L
		}, null).write('" class="input-small needs-datepicker" maxlength="10" value="').reference(b.get("tdate"), b, "h").write('" /><input type="text" name="').notexists(b.get("add"),
		b, {
			"else": M,
			block: N
		}, null).write('" class="input-mini needs-timepicker" maxlength="10" value="').reference(b.get("ttime"), b, "h").write('" />').notexists(b.get("add"), b, {
			block: O
		}, null)
	}
	function K(a) {
		return a.write("tdate")
	}
	function L(a) {
		return a.write("reminders[tdate][]")
	}
	function M(a) {
		return a.write("ttime")
	}
	function N(a) {
		return a.write("reminders[ttime][]")
	}
	function O(a) {
		return a.write('<input type="hidden" name="reminders[qty][]" value="" /><input type="hidden" name="reminders[interval][]" value="" /><input type="hidden" name="reminders[before][]" value="" />')
	}

	function p(a, b) {
		return a.write('<img src="').reference(b.get("base_url"), b, "h").write('img/delete.png" class="reminder_delete pseudobutton" alt="').helper("i18n", b, {}, {
			type: "labels",
			name: "delete"
		}).write('" title="').helper("i18n", b, {}, {
			type: "labels",
			name: "delete"
		}).write('" />')
	}
	function q(a, b) {
		return a.write('<img src="').reference(b.get("base_url"), b, "h").write('img/add.png" class="reminder_add_button pseudobutton" alt="').helper("i18n", b, {}, {
			type: "labels",
			name: "add"
		}).write('" title="').helper("i18n",
		b, {}, {
			type: "labels",
			name: "add"
		}).write('" />')
	}
	dust.register("reminder_row", a);
	return a
})();
(function() {
	function a(a, b) {
		return a.write('<div id="event_delete_dialog">').partial("form_open", b, null).write('<input type="hidden" name="calendar" value="').reference(b.get("calendar"), b, "h").write('" /><input type="hidden" name="uid" value="').reference(b.get("uid"), b, "h").write('" /><input type="hidden" name="href" value="').reference(b.get("href"), b, "h").write('" /><input type="hidden" name="etag" value="').reference(b.get("etag"), b, "h").write('" /><p>').helper("i18n", b, {}, {
			type: "messages",
			name: "info_confirmeventdelete"
		}).write('</p><p class="title">').reference(b.get("title"),
		b, "h").write("</p>").exists(b.get("rrule"), b, {
			block: e
		}, null).partial("form_close", b, null).write("</div>")
	}
	function e(a, b) {
		return a.write("<p>").helper("i18n", b, {}, {
			type: "messages",
			name: "info_repetitivedeleteall"
		}).write("</p>")
	}
	dust.register("event_delete_dialog", a);
	return a
})();
(function() {
	function a(a, c) {
		return a.write('<li class="available_calendar').exists(c.get("default_calendar"), c, {
			block: e
		}, null).write('"><div class="calendar_color" style="background-color:').exists(c.get("color"), c, {
			"else": d,
			block: b
		}, null).write("; border-color: ").reference(c.get("bordercolor"), c, "h").write('"></div><span class="icons">').exists(c.get("shared"), c, {
			"else": f,
			block: h
		}, null).write('</span><span class="text"').exists(c.get("user_from"), c, {
			block: g
		}, null).write(">").reference(c.get("displayname"),
		c, "h").write('</span><i title="').helper("i18n", c, {}, {
			type: "labels",
			name: "modifycalendar"
		}).write('" class="cfg pseudobutton icon-cogs"></i></li>')
	}
	function e(a) {
		return a.write(" default_calendar")
	}
	function d(a, b) {
		return a.reference(b.get("default_calendar_color"), b, "h")
	}
	function b(a, b) {
		return a.reference(b.get("color"), b, "h")
	}
	function f(a, b) {
		return a.exists(b.get("share_with"), b, {
			block: j
		}, null)
	}
	function j(a, b) {
		return a.write('<i title="').helper("i18n", b, {}, {
			type: "labels",
			name: "currentlysharing"
		}).write('" class="icon-share"></i>')
	}

	function h(a, b) {
		return a.helper("eq", b, {
			block: k
		}, {
			key: l,
			value: "0"
		})
	}
	function k(a, b) {
		return a.write('<i title="').helper("i18n", b, {}, {
			type: "labels",
			name: "readonly"
		}).write('" class="icon-lock"></i>')
	}
	function l(a, b) {
		return a.reference(b.get("write_access"), b, "h")
	}
	function g(a, b) {
		return a.write('title="').helper("i18n", b, {}, {
			type: "messages",
			name: "info_sharedby",
			user: c
		}).write('"')
	}
	function c(a, b) {
		return a.reference(b.get("user_from"), b, "h")
	}
	dust.register("calendar_list_entry", a);
	return a
})();
(function() {
	function a(a, b) {
		return a.exists(b.get("is_absolute"), b, {
			"else": e,
			block: n
		}, null)
	}
	function e(a, b) {
		return a.reference(b.get("qty"), b, "h").write(" ").helper("select", b, {
			block: d
		}, {
			key: k
		}).write(" ").exists(b.get("before"), b, {
			"else": l,
			block: g
		}, null).write(" ").exists(b.get("relatedStart"), b, {
			"else": c,
			block: m
		}, null)
	}
	function d(a, c) {
		return a.helper("eq", c, {
			block: b
		}, {
			value: "min"
		}).helper("eq", c, {
			block: f
		}, {
			value: "hour"
		}).helper("eq", c, {
			block: j
		}, {
			value: "day"
		}).helper("eq", c, {
			block: h
		}, {
			value: "week"
		})
	}

	function b(a, b) {
		return a.helper("i18n", b, {}, {
			type: "labels",
			name: "minutes"
		})
	}
	function f(a, b) {
		return a.helper("i18n", b, {}, {
			type: "labels",
			name: "hours"
		})
	}
	function j(a, b) {
		return a.helper("i18n", b, {}, {
			type: "labels",
			name: "days"
		})
	}
	function h(a, b) {
		return a.helper("i18n", b, {}, {
			type: "labels",
			name: "weeks"
		})
	}
	function k(a, b) {
		return a.reference(b.get("interval"), b, "h")
	}
	function l(a, b) {
		return a.helper("i18n", b, {}, {
			type: "labels",
			name: "after"
		})
	}
	function g(a, b) {
		return a.helper("i18n", b, {}, {
			type: "labels",
			name: "before"
		})
	}

	function c(a, b) {
		return a.helper("i18n", b, {}, {
			type: "labels",
			name: "end"
		})
	}
	function m(a, b) {
		return a.helper("i18n", b, {}, {
			type: "labels",
			name: "start"
		})
	}
	function n(a, b) {
		return a.reference(b.get("tdate"), b, "h").write(" ").reference(b.get("ttime"), b, "h")
	}
	dust.register("reminder_description", a);
	return a
})();
var ved = "div.view_event_details",
	ced = "#com_event_dialog",
	dustbase = {};
$(document).ready(function() {
	load_i18n_strings();
	dust.helpers.i18n = function(a, b, c, d) {
		var c = {}, e = d.name,
			f = d.type;
		delete d.name;
		delete d.type;
		for (var g in d) d.hasOwnProperty(g) && (c["%" + g] = dust.helpers.tap(d[g], a, b));
		return a.write(t(f, e, c))
	};
	$("body").hasClass("loginpage") ? ($("input:submit").button(), $('input[name="user"]').focus()) : $("body").hasClass("prefspage") ? ($("#prefs_tabs").tabs(), $("#prefs_buttons button").button(), $("#return_button").on("click", function() {
		window.location = base_app_url;
		return false
	}),
	$("#save_button").on("click", function() {
		var a = $("#prefs_form");
		proceed_send_ajax_form(a, function() {
			show_success(t("messages", "info_prefssaved"), "")
		}, function(a) {
			show_error(t("messages", "error_invalidinput"), a)
		}, function() {})
	})) : $("body").hasClass("calendarpage") && (dustbase = dust.makeBase({
		default_calendar_color: default_calendar_color,
		base_url: base_url,
		base_app_url: base_app_url,
		csrf_token_name: AgenDAVConf.prefs_csrf_token_name,
		enable_calendar_sharing: enable_calendar_sharing
	}), set_default_colorpicker_options(),
	$("#calendar_view").fullCalendar({
		selectable: true,
		editable: true,
		firstDay: AgenDAVConf.prefs_firstday,
		timeFormat: {
			agenda: AgenDAVConf.prefs_timeformat + "{ - " + AgenDAVConf.prefs_timeformat + "}",
			"": AgenDAVConf.prefs_timeformat
		},
		columnFormat: {
			month: AgenDAVConf.prefs_format_column_month,
			week: AgenDAVConf.prefs_format_column_week,
			day: AgenDAVConf.prefs_format_column_day,
			table: AgenDAVConf.prefs_format_column_table
		},
		titleFormat: {
			month: AgenDAVConf.prefs_format_title_month,
			week: AgenDAVConf.prefs_format_title_week,
			day: AgenDAVConf.prefs_format_title_day,
			table: AgenDAVConf.prefs_format_title_table
		},
		currentTimeIndicator: true,
		weekMode: "liquid",
		height: calendar_height(),
		windowResize: function() {
			$(this).fullCalendar("option", "height", calendar_height())
		},
		header: {
			left: "month,agendaWeek,agendaDay table",
			center: "title",
			right: "today prev,next"
		},
		listTexts: {
			until: t("labels", "repeatuntil"),
			past: t("labels", "pastevents"),
			today: t("labels", "today"),
			tomorrow: t("labels", "tomorrow"),
			thisWeek: t("labels", "thisweek"),
			nextWeek: t("labels",
				"nextweek"),
			thisMonth: t("labels", "thismonth"),
			nextMonth: t("labels", "nextmonth"),
			future: t("labels", "future"),
			week: "W"
		},
		listSections: "smart",
		listRange: 30,
		listPage: 7,
		monthNames: month_names_long(),
		monthNamesShort: month_names_short(),
		dayNames: day_names_long(),
		dayNamesShort: day_names_short(),
		buttonText: {
			today: t("labels", "today"),
			month: t("labels", "month"),
			week: t("labels", "week"),
			day: t("labels", "day"),
			table: t("labels", "tableview")
		},
		theme: true,
		allDayText: t("labels", "allday"),
		axisFormat: AgenDAVConf.prefs_timeformat,
		slotMinutes: 30,
		firstHour: 8,
		allDayDefault: false,
		loading: function(a) {
			loading(a)
		},
		eventRender: event_render_callback,
		eventClick: event_click_callback,
		select: slots_drag_callback,
		selectHelper: select_helper,
		eventResize: event_resize_callback,
		eventDrop: event_drop_callback
	}), $('<span class="fc-button-refresh"><i class="icon-refresh"></i> ' + t("labels", "refresh") + "</span>").appendTo("#calendar_view td.fc-header-right").button().on("click", function() {
		update_calendar_list(true)
	}).before('<span class="fc-header-space">'),
	dust.render("datepicker_button", dustbase, function(a, b) {
		a != null ? show_error(t("messages", "error_interfacefailure"), a.message) : ($("#calendar_view span.fc-button-next").after(b), $("#datepicker_fullcalendar").datepicker({
			changeYear: true,
			closeText: t("labels", "cancel"),
			onSelect: function() {
				var a = $("#datepicker_fullcalendar").datepicker("getDate");
				$("#calendar_view").fullCalendar("gotoDate", a)
			}
		}).prev().button().on("click", function() {
			$("#datepicker_fullcalendar").datepicker("setDate", $("#calendar_view").fullCalendar("getDate"));
			$("#datepicker_fullcalendar").datepicker("show")
		}))
	}), $("#calendar_view").fullCalendar("renderEvent", {
		title: "Little portal",
		start: "1985-02-15T00:00:00Z",
		end: "1985-02-15T23:59:59Z",
		allDay: true,
		editable: false,
		color: "#E78AEF"
	}, true), $("div.calendar_list").on("click", "i.cfg", function(a) {
		a.stopPropagation();
		a = $(this).parent();
		calendar_modify_dialog($(a[0]).data())
	}).on("click", "li.available_calendar", function() {
		toggle_calendar($(this))
	}), update_calendar_list(true), $("#sidebar").on("click", "#toggle_all_shared_calendars",

	function() {
		var a = $("#shared_calendar_list").find("ul").children();
		$(this).hasClass("hide_all") ? ($.map(a, function(a) {
			hide_calendar($(a))
		}), $(this).removeClass("hide_all").addClass("show_all").find("i").removeClass("icon-eye-close").addClass("icon-eye-open")) : ($.map(a, function(a) {
			show_calendar($(a))
		}), $(this).removeClass("show_all").addClass("hide_all").find("i").removeClass("icon-eye-open").addClass("icon-eye-close"))
	}), $("#sidebar div.buttons").find("img[title],span[title],a[title]").qtip({
		position: {
			my: "top left",
			at: "bottom left"
		},
		show: {
			delay: 600
		},
		style: {
			classes: "ui-tooltip-bootstrap",
			tip: true
		}
	}), $("#calendar_add").on("click", calendar_create_dialog), $("#shortcut_add_event").button({
		icons: {
			primary: "ui-icon-plusthick"
		}
	}).on("click", function() {
		var a = {
			start: fulldatetimestring($("#calendar_view").fullCalendar("getDate")),
			allday: false,
			view: "month"
		};
		$("#calendar_view").fullCalendar("unselect");
		event_field_form("new", a)
	}));
	setup_print_tweaks();
	$("#usermenu").qtip({
		content: $("#usermenu_content"),
		position: {
			my: "top center",
			at: "bottom center"
		},
		style: {
			tip: true,
			classes: "ui-tooltip-bootstrap agendav-menu"
		},
		show: {
			event: "click",
			effect: false,
			delay: 0
		},
		hide: {
			event: "unfocus"
		}
	})
});
var calendar_height = function() {
	var a = $("#calendar_view").offset();
	return $(window).height() - Math.ceil(a.top) - 30
}, show_error = function(a, b) {
	loading(false);
	$("#popup").freeow(a, b, {
		classes: ["popup_error"],
		autoHide: false,
		showStyle: {
			opacity: 1,
			left: 0
		},
		hideStyle: {
			opacity: 0,
			left: "400px"
		}
	})
}, show_success = function(a, b) {
	$("#popup").freeow(a, b, {
		classes: ["popup_success"],
		autoHide: true,
		autoHideDelay: 2E3,
		showStyle: {
			opacity: 1,
			left: 0
		},
		hideStyle: {
			opacity: 0,
			left: "400px"
		}
	})
}, get_data = function(a) {
	return $.data($("body")[0],
	a)
}, set_data = function(a, b) {
	$.data($("body")[0], a, b)
}, remove_data = function(a) {
	$.removeData($("body")[0], a)
}, load_generated_dialog = function(a, b, c, d, e, f, g) {
	f = "#" + f;
	if ($(f).length != 0) return false;
	b = generate_on_the_fly_form(base_app_url + "event/modify", b);
	if (get_data("formcreation") == "ok") {
		b = $("#" + b);
		$(b).attr("action");
		var h = $(b).serialize(),
			a = $.ajax({
				url: base_app_url + a,
				cache: false,
				type: "POST",
				data: h,
				dataType: "html"
			});
		a.then(function() {
			loading(false)
		});
		a.fail(function(a, b) {
			show_error(t("messages", "error_loading_dialog"),
			t("messages", "error_oops") + ": " + b)
		});
		a.done(function(a) {
			$("body").append(a);
			$(f).dialog({
				autoOpen: true,
				buttons: e,
				title: d,
				minWidth: g,
				modal: true,
				open: function(a) {
					c();
					$(f).dialog("option", "position", "center");
					a = $(a.target).parent().find(".ui-dialog-buttonset").children();
					add_button_icons(a)
				},
				close: function() {
					$(this).remove()
				}
			})
		});
		$(b).remove()
	} else show_error(t("messages", "error_interfacefailure"), t("messages", "error_oops"))
}, proceed_send_ajax_form = function(a, b, c, d) {
	var e = $(a).attr("action"),
		a = $(a).serialize();
	loading(true);
	e = $.ajax({
		url: e,
		cache: false,
		type: "POST",
		data: a,
		dataType: "json"
	});
	e.then(function() {
		loading(false)
	});
	e.fail(function(a, b) {
		show_error(t("messages", "error_interfacefailure"), t("messages", "error_oops") + ":" + b);
		set_data("lastoperation", "failed");
		d()
	});
	e.done(function(a) {
		var e = a.result,
			a = a.message;
		e == "ERROR" ? (set_data("lastoperation", "failed"), show_error(t("messages", "error_internal"), a), d()) : e == "EXCEPTION" ? (set_data("lastoperation", "failed"), c(a)) : e == "SUCCESS" ? (set_data("lastoperation", "success"),
		b(a)) : show_error(t("messages", "error_internal"), t("messages", "error_oops") + ":" + e)
	})
}, show_dialog = function(a, b, c, d, e, f, g) {
	dust.render(a, dustbase.push(b), function(a, b) {
		a != null ? show_error(t("messages", "error_interfacefailure"), a.message) : ($("body").append(b), $("#" + e).dialog({
			autoOpen: true,
			buttons: d,
			title: c,
			minWidth: f,
			modal: true,
			open: function(a) {
				g();
				$(e).dialog("option", "position", "center");
				a = $(a.target).parent().find(".ui-dialog-buttonset").children();
				add_button_icons(a)
			},
			close: function() {
				$(this).remove()
			}
		}))
	})
},
generate_on_the_fly_form = function(a, b) {
	for (var c = "", d = 0; d < 10; d++) c += "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".charAt(Math.floor(Math.random() * 62));
	d = $.ajax({
		url: base_app_url + "dialog_generator/on_the_fly_form/" + c,
		cache: false,
		type: "POST",
		contentType: "text",
		dataType: "text",
		async: false
	});
	d.fail(function() {
		session_expired();
		set_data("formcreation", "failed")
	});
	d.done(function(c) {
		var d = "";
		$.each(b, function(a, b) {
			d += '<input type="hidden" name="' + a + '" value="' + b + '" />'
		});
		$(c).append(d).attr("action",
		a).appendTo(document.body);
		set_data("formcreation", "ok")
	});
	return c
}, destroy_dialog = function(a) {
	$(a).dialog("close");
	$(a).dialog("destroy");
	$(a).remove()
}, set_default_datepicker_options = function() {
	$.datepicker.regional.custom = {
		closeText: t("labels", "close"),
		prevText: t("labels", "previous"),
		nextText: t("labels", "next"),
		currentText: t("labels", "today"),
		monthNames: month_names_long(),
		monthNamesShort: month_names_short(),
		dayNames: day_names_long(),
		dayNamesShort: day_names_short(),
		dayNamesMin: day_names_short(),
		weekHeader: "Sm",
		firstDay: AgenDAVConf.prefs_firstday,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ""
	};
	$.datepicker.setDefaults($.datepicker.regional.custom);
	$.datepicker.setDefaults({
		constrainInput: true
	});
	$.datepicker.setDefaults({
		dateFormat: AgenDAVConf.prefs_dateformat
	})
}, set_end_minDate = function() {
	var a = ced + " input.end_date",
		b = ced + " input.recurrence_until",
		c = $(ced + " input.start_date").datepicker("getDate");
	c.setTime(c.getTime());
	$(a).datepicker("option", "minDate", c);
	$(b).datepicker("option", "minDate",
	c)
}, update_recurrence_options = function(a) {
	a == "none" ? ($(ced + " input.recurrence_count").val(""), $(ced + " input.recurrence_until").val(""), $(ced + " input.recurrence_count").attr("disabled", "disabled"), $(ced + " input.recurrence_count").addClass("ui-state-disabled"), $(ced + ' label[for="recurrence_count"]').addClass("ui-state-disabled"), $(ced + " input.recurrence_until").attr("disabled", "disabled"), $(ced + " input.recurrence_until").datepicker("disable"), $(ced + " input.recurrence_until").addClass("ui-state-disabled"),
	$(ced + ' label[for="recurrence_until"]').addClass("ui-state-disabled")) : (enforce_exclusive_recurrence_field("recurrence_count", "recurrence_until"), enforce_exclusive_recurrence_field("recurrence_until", "recurrence_count"))
}, event_field_form = function(a, b) {
	var c = "dialog_generator/",
		d;
	a == "new" ? (c += "create_event", d = t("labels", "createevent")) : (c += "edit_event", d = t("labels", "editevent"));
	load_generated_dialog(c, b, function() {
		$(ced + "_tabs").tabs();
		$(ced + " input.start_time").timePicker(AgenDAVConf.timepicker_base);
		$(ced + " input.end_time").timePicker(AgenDAVConf.timepicker_base);
		$(ced + " input.start_date").datepicker({
			onSelect: function() {
				set_end_minDate()
			}
		});
		$(ced + " input.end_date").datepicker();
		$(ced + " input.recurrence_until").datepicker();
		$(ced + " input.end_time").data("untouched", true);
		set_end_minDate();
		update_recurrence_options($(ced + " select.recurrence_type").val());
		$(ced).on("change", "input.allday", function() {
			var a = $(ced + " input.start_date").datepicker("getDate");
			set_end_minDate();
			$(this).is(":checked") ? ($(ced + " input.start_time").hide(), $(ced + " input.end_time").hide()) : ($(ced + " input.end_date").removeAttr("disabled"), $(ced + " input.end_date").removeClass("ui-state-disabled"), $(ced + " input.end_date").datepicker("setDate", a), $(ced + " input.start_time").show(), $(ced + " input.end_time").show())
		});
		$(ced).on("change", "select.recurrence_type", function() {
			$(this).val();
			update_recurrence_options($(this).val())
		});
		$(ced).on("keyup", "input.recurrence_count", function() {
			enforce_exclusive_recurrence_field("recurrence_count",
				"recurrence_until")
		}).on("keyup change", "input.recurrence_until", function() {
			enforce_exclusive_recurrence_field("recurrence_until", "recurrence_count")
		});
		var c = $.timePicker(ced + " input.start_time").getTime(),
			d = $.timePicker(ced + " input.end_time").getTime() - c.getTime();
		$(ced).on("change", "input.start_time", function() {
			if ($(ced + " input.end_time").data("untouched")) {
				var a = $.timePicker(ced + " input.start_time").getTime(),
					b = $.timePicker(ced + " input.end_time").getTime() - c.getTime();
				$.timePicker(ced + " input.end_time").setTime(new Date(a.getTime() + b));
				c = a
			}
		});
		$(ced).on("change", "input.end_time", function() {
			$.timePicker(this).getTime() - $.timePicker(ced + " input.start_time").getTime() != d && $(this).data("untouched", false)
		});
		a == "new" && $('input[name="summary"]').focus();
		dust.render("reminders_table", dustbase.push(b), function(a, b) {
			a != null ? show_error(t("messages", "error_interfacefailure"), a.message) : ($("#tabs-reminders").html(b), reminders_manager())
		})
	}, d, [{
		text: t("labels", "save"),
		"class": "addicon btn-icon-event-edit",
		click: function() {
			var a = $("#com_form");
			proceed_send_ajax_form(a, function(a) {
				$.each(a, function(a, b) {
					reload_event_source(b)
				});
				destroy_dialog(ced)
			}, function(a) {
				show_error(t("messages", "error_invalidinput"), a)
			}, function() {})
		}
	}, {
		text: t("labels", "cancel"),
		"class": "addicon btn-icon-cancel",
		click: function() {
			destroy_dialog(ced)
		}
	}], "com_event_dialog", 550)
}, update_single_event = function(a, b) {
	$.each(b, function(b, d) {
		a[b] = d
	});
	$("#calendar_view").fullCalendar("updateEvent", a)
}, calendar_create_dialog = function() {
	var a = base_app_url + "calendar/create",
		b = t("labels",
			"newcalendar"),
		a = {
			applyid: "calendar_create_form",
			frm: {
				action: a,
				method: "post",
				csrf: get_csrf_token()
			}
		};
	show_dialog("calendar_create_dialog", a, b, [{
		text: t("labels", "create"),
		"class": "addicon btn-icon-calendar-add",
		click: function() {
			var a = $("#calendar_create_form");
			proceed_send_ajax_form(a, function() {
				destroy_dialog("#calendar_create_dialog");
				update_calendar_list(false)
			}, function(a) {
				show_error(t("messages", "error_invalidinput"), a)
			}, function() {})
		}
	}, {
		text: t("labels", "cancel"),
		"class": "addicon btn-icon-cancel",
		click: function() {
			destroy_dialog("#calendar_create_dialog")
		}
	}], "calendar_create_dialog", 400, function() {
		$("input.pick_color").colorPicker()
	})
}, calendar_modify_dialog = function(a) {
	var b = base_app_url + "calendar/modify",
		c = t("labels", "modifycalendar");
	$.extend(a, {
		applyid: "calendar_modify_form",
		frm: {
			action: b,
			method: "post",
			csrf: get_csrf_token()
		}
	});
	b = [{
		text: t("labels", "deletecalendar"),
		"class": "addicon btn-icon-calendar-delete",
		click: function() {
			calendar_delete_dialog(a)
		}
	}, {
		text: t("labels", "save"),
		"class": "addicon btn-icon-calendar-edit",
		click: function() {
			var a = $("#calendar_modify_form");
			proceed_send_ajax_form(a, function() {
				destroy_dialog("#calendar_modify_dialog");
				update_calendar_list(false)
			}, function(a) {
				show_error(t("messages", "error_invalidinput"), a)
			}, function() {})
		}
	}, {
		text: t("labels", "cancel"),
		"class": "addicon btn-icon-cancel",
		click: function() {
			destroy_dialog("#calendar_modify_dialog")
		}
	}];
	a.shared === true && b.splice(0, 1);
	show_dialog("calendar_modify_dialog", a, c, b, "calendar_modify_dialog", 500, function() {
		$("input.pick_color").colorPicker();
		$("#calendar_modify_dialog_tabs").tabs();
		enable_calendar_sharing === true && a.shared !== true && share_manager()
	})
}, calendar_delete_dialog = function(a) {
	destroy_dialog("#calendar_modify_dialog");
	var b = base_app_url + "calendar/delete",
		c = t("labels", "deletecalendar");
	$.extend(a, {
		applyid: "calendar_delete_form",
		frm: {
			action: b,
			method: "post",
			csrf: get_csrf_token()
		}
	});
	show_dialog("calendar_delete_dialog", a, c, [{
		text: t("labels", "yes"),
		"class": "addicon btn-icon-calendar-delete",
		click: function() {
			var a = $("#calendar_delete_form");
			proceed_send_ajax_form(a, function(a) {
				$(".calendar_list li.available_calendar").each(function() {
					var b = $(this).data();
					if (b.calendar == a) return $("#calendar_view").fullCalendar("removeEventSource", b.eventsource), $(this).remove(), false
				})
			}, function(a) {
				show_error(t("messages", "error_caldelete"), a)
			}, function() {});
			destroy_dialog("#calendar_delete_dialog")
		}
	}, {
		text: t("labels", "cancel"),
		"class": "addicon btn-icon-cancel",
		click: function() {
			destroy_dialog("#calendar_delete_dialog")
		}
	}], "calendar_delete_dialog", 500,

	function() {})
}, update_calendar_list = function update_calendar_list(b) {
	b && loading(true);
	var c = $.ajax({
		url: base_app_url + "calendar/all",
		cache: false,
		dataType: "json",
		async: false
	});
	c.then(function() {
		b && loading(false)
	});
	c.fail(function(b, c) {
		show_error(t("messages", "error_loading_calendar_list"), t("messages", "error_oops") + c)
	});
	c.done(function(b) {
		var c = {};
		$(".calendar_list li.available_calendar").each(function() {
			var b = $(this).data();
			$("#calendar_view").fullCalendar("removeEventSource", b.eventsource);
			$(this).hasClass("transparent") && (c[b.calendar] = true);
			$(this).remove()
		});
		var f = 0,
			g = 0,
			h = document.createDocumentFragment(),
			i = document.createDocumentFragment(),
			j = [];
		$.each(b, function(b, d) {
			f++;
			d.color = d.color === void 0 || d.color === false || d.color == null ? default_calendar_color : d.color.substr(0, 7);
			d.fg = fg_for_bg(d.color);
			d.bordercolor = $.color.parse(d.color).scale("rgb", d.fg == "#000000" ? 0.8 : 1.8).toString();
			var k = generate_calendar_entry(d);
			c[d.calendar] ? k.addClass("transparent") : j.push($(k).data().eventsource);
			d.shared == true ? (g++, i.appendChild(k[0])) : h.appendChild(k[0])
		});
		if (f == 0) b = get_data("last_calendar_count"), b === void 0 || b != "0" ? (set_data("last_calendar_count", 0), setTimeout(function() {
			update_calendar_list(false)
		}, 1)) : (show_error(t("messages", "notice_no_calendars"), ""), $("#shortcut_add_event").button("disable"));
		else {
			set_data("last_calendar_count", f);
			$("#own_calendar_list ul")[0].appendChild(h);
			g == 0 ? $("#shared_calendar_list").hide() : ($("#shared_calendar_list ul")[0].appendChild(i), $("#shared_calendar_list").show());
			for (; f--;) $("#calendar_view").fullCalendar("addEventSource",
			j[f]);
			$("#shortcut_add_event").button("enable")
		}
	})
}, generate_event_source = function(a) {
	return {
		url: base_app_url + "event/all#" + a,
		cache: false,
		data: {
			calendar: a
		},
		error: function(b) {
			b.status !== void 0 && b.status == 401 ? session_expired() : show_error(t("messages", "error_interfacefailure"), t("messages", "error_loadevents", {
				"%cal": a
			}))
		},
		startParamUTC: true,
		endParamUTC: true
	}
}, session_refresh = function session_refresh(b) {
	var c = $.ajax({
		url: base_app_url + "js_generator/keepalive",
		cache: false,
		method: "GET",
		dataType: "html"
	});
	c.done(function(c) {
		c !== "" ? $("body").append(c) : setTimeout(function() {
			session_refresh(b)
		}, b)
	});
	c.fail(function() {
		session_expired()
	})
}, add_button_icons = function(a) {
	a.filter("button.addicon").removeClass("addicon").removeClass("ui-button-text-only").addClass("ui-button-text-icon-primary").each(function(a, c) {
		var d = $(c).attr("class").split(" ");
		$.each(d, function(a, b) {
			if (b.match(/^btn-icon-/)) return $(c).prepend('<span class="ui-button-icon-primary ui-icon ' + b + '"></span>'), $(c).removeClass(b), false
		})
	})
},
generate_calendar_entry = function(a) {
	var b = generate_event_source(a.calendar);
	b.ignoreTimezone = true;
	b.color = a.color;
	b.textColor = a.fg;
	b.borderColor = a.bordercolor;
	if (a.shared !== void 0 && a.shared == true && a.write_access == "0") b.editable = false;
	a.eventsource = b;
	var c;
	dust.render("calendar_list_entry", dustbase.push(a), function(b, e) {
		b != null ? show_error(t("messages", "error_interfacefailure"), b.message) : (c = $(e), c.data(a), c.disableSelection(), c.find("span[title],i[title]").qtip({
			position: {
				my: "top left",
				at: "bottom left"
			},
			show: {
				delay: 600
			},
			style: {
				classes: "ui-tooltip-bootstrap",
				tip: true
			}
		}))
	});
	return c
}, get_calendar_data = function(a) {
	var b = void 0;
	$(".calendar_list li.available_calendar").each(function() {
		var c = $(this).data();
		if (c.calendar == a) return b = c, false
	});
	return b
}, get_calendar_displayname = function(a) {
	a = get_calendar_data(a);
	return a === void 0 || a.displayname === void 0 ? "(?)" : a.displayname
}, reload_event_source = function(a) {
	var b = void 0;
	$(".calendar_list li.available_calendar").each(function() {
		var c = $(this).data();
		if (c.calendar == a) return b = c.eventsource, false
	});
	b !== void 0 ? ($("#calendar_view").fullCalendar("removeEventSource", b), $("#calendar_view").fullCalendar("addEventSource", b)) : show_error(t("messages", "error_interfacefailure"), t("messages", "error_calendarnotfound", {
		"%calendar": a
	}))
}, enforce_exclusive_recurrence_field = function(a, b) {
	$(ced + " input." + a).val() == "" ? ($(ced + " input." + b).removeAttr("disabled"), $(ced + " input." + b).removeClass("ui-state-disabled"), $(ced + ' label[for="' + b + '"]').removeClass("ui-state-disabled"), b == "recurrence_until" && $(ced + " input." + b).datepicker("enable")) : ($(ced + " input." + b).attr("disabled", "disabled"), $(ced + " input." + b).addClass("ui-state-disabled"), $(ced + " input." + b).val(""), $(ced + ' label[for="' + b + '"]').addClass("ui-state-disabled"), b == "recurrence_until" && $(ced + " input." + b).datepicker("disable"))
}, timestamp = function(a) {
	return Math.round(a.getTime() / 1E3)
}, fulldatetimestring = function(a) {
	if (a != void 0) return $.fullCalendar.formatDate(a, "yyyyMMddHHmmss")
}, fg_for_bg = function(a) {
	a = parseInt(a.substr(1), 16);
	return (a >>> 16) + (a >>> 8 & 255) + (a & 255) < 500 ? "#ffffff" : "#000000"
}, session_expired = function() {
	$(".ui-dialog-content").dialog("close");
	show_error(t("messages", "error_sessexpired"), t("messages", "error_loginagain"));
	setTimeout(function() {
		window.location = base_url
	}, 2E3)
}, share_manager = function() {
	var a = $("#calendar_share_table"),
		b = $("#calendar_share_add");
	share_manager_no_entries_placeholder();
	a.on("click", ".calendar_share_delete", function() {
		$(this).parent().parent().fadeOut("fast", function() {
			$(this).remove();
			share_manager_no_entries_placeholder()
		})
	});
	var c = {}, d;
	b.find("#calendar_share_add_username").autocomplete({
		minLength: 3,
		source: function(a, b) {
			var g = a.term;
			g in c ? b(c[g]) : d = $.getJSON(base_app_url + "caldav2json/principal_search", a, function(a, e, j) {
				c[g] = a;
				j === d && b(a)
			})
		},
		focus: function(a, b) {
			$(this).val(b.item.username);
			return false
		},
		select: function(a, b) {
			$(this).val(b.item.username);
			return false
		}
	}).data("autocomplete")._renderItem = function(a, b) {
		return $("<li></li>").data("item.autocomplete", b).append('<a><i class="icon-user"></i> ' + b.displayname + '<span style="font-style: italic"> &lt;' + b.email + "&gt;</span></a>").appendTo(a)
	};
	b.on("click", "#calendar_share_add_button", function() {
		var b = $("#calendar_share_add_username").val(),
			c = $("#calendar_share_add_write_access").val();
		if (b != "") {
			var d = false;
			a.find("span.username").each(function() {
				!d && $(this).text() == b && (d = true, $(this).parent().parent().effect("highlight", {}, "slow"))
			});
			d || dust.render("calendar_share_row", dustbase.push({
				username: b,
				write_access: c
			}), function(b, c) {
				b != null ? show_error(t("messages", "error_interfacefailure"), b.message) : (a.find("tbody").append(c),
				$("#calendar_share_add_username").val(""), $("#calendar_share_add_write_access").val("0"), share_manager_no_entries_placeholder())
			})
		}
	})
}, share_manager_no_entries_placeholder = function() {
	$("#calendar_share_table").find("tbody tr").length == 1 ? $("#calendar_share_no_rows").show() : $("#calendar_share_no_rows").hide()
}, reminders_manager = function() {
	var a = $("#tabs-reminders"),
		b = $("#reminders_table");
	initialize_date_and_time_pickers(a);
	reminders_manager_no_entries_placeholder();
	b.on("click", ".reminder_delete",

	function() {
		$(this).parent().parent().fadeOut("fast", function() {
			$(this).remove();
			reminders_manager_no_entries_placeholder()
		})
	});
	b.parent().on("click", "img.reminder_add_button", function() {
		var c = $(this).closest("tbody").serializeObject(),
			d = false,
			e = /^[0-9]+$/;
		c.is_absolute === false ? c.qty !== "" && e.test(c.qty) && c.interval !== "" && c.before !== "" && (d = true) : c.tdate !== "" && c.ttime !== "" && (d = true);
		if (d === true) {
			var f = $(this).closest("tr");
			dust.render("reminder_row", dustbase.push(c), function(c, d) {
				c != null ? show_error(t("messages",
					"error_interfacefailure"), c.message) : (b.find("tbody").append(d), f.find("input").val(""), f.find("select").val(""), initialize_date_and_time_pickers(a), reminders_manager_no_entries_placeholder())
			})
		}
	})
}, reminders_manager_no_entries_placeholder = function() {
	$("#reminders_table").find("tbody tr").length == 1 ? $("#reminders_no_rows").show() : $("#reminders_no_rows").hide()
}, event_render_callback = function(a, b) {
	var c = get_calendar_data(a.calendar),
		d = $.extend({}, a, {
			caldata: c
		});
	c !== void 0 && c.shared === true && c.write_access ==
		"0" && $.extend(d, {
		disable_actions: true
	});
	c = [];
	a.rrule != void 0 && c.push("icon-repeat");
	a.reminders.length > 0 && c.push("icon-bell");
	if (c.length != 0) {
		var e = $('<span class="fc-event-icons"></span>');
		$.each(c, function(a, b) {
			e.append('<i class="' + b + '"></i>')
		});
		b.hasClass("fc-event-row") || b.find(".fc-event-title").after(e)
	}
	dust.render("event_details_popup", dustbase.push(d), function(c, d) {
		c != null ? show_error(t("messages", "error_interfacefailure"), c.message) : b.qtip({
			content: {
				text: d,
				title: {
					text: a.title,
					button: true
				}
			},
			position: {
				my: "bottom center",
				at: "top center",
				viewport: $("#calendar_view")
			},
			style: {
				classes: "view_event_details ui-tooltip-bootstrap",
				tip: true
			},
			show: {
				target: $("#calendar_view"),
				event: false,
				solo: $("#calendar_view"),
				effect: false
			},
			hide: {
				fixed: true,
				event: "unfocus",
				effect: false
			},
			events: {
				show: function(a, b) {
					$(this).find("button.link_delete_event").off("click").on("click", function() {
						event_delete_dialog()
					}).end().find("button.link_modify_event").off("click").on("click", function() {
						modify_event_handler()
					});
					$(window).on("keydown.tooltipevents",

					function(a) {
						a.keyCode === $.ui.keyCode.ESCAPE && b.hide(a)
					});
					var c = b.elements.tooltip.find("div.actions").find("button.addicon").button();
					add_button_icons(c)
				},
				hide: function() {
					remove_data("current_event");
					$(window).off("keydown.tooltipevents")
				}
			}
		})
	})
}, event_click_callback = function(a, b) {
	get_data("current_event") == a ? ($(ved).qtip("hide"), remove_data("current_event")) : (set_data("current_event", a), $(this).qtip("show", b))
}, slots_drag_callback = function(a, b, c, d, e) {
	c = e.name == "month" ? false : c;
	a = {
		start: fulldatetimestring(a),
		end: fulldatetimestring(b),
		allday: c,
		view: e.name
	};
	$("#calendar_view").fullCalendar("unselect");
	event_field_form("new", a)
}, select_helper = function(a, b) {
	return $('<div style="border: 1px solid black; background-color: #f0f0f0;" class="selecthelper"/>').text($.fullCalendar.formatDates(a, b, AgenDAVConf.prefs_timeformat + "{ - " + AgenDAVConf.prefs_timeformat + "}"))
}, event_resize_callback = function(a, b, c, d, e, f, g) {
	b = generate_on_the_fly_form(base_app_url + "event/alter", {
		uid: a.uid,
		calendar: a.calendar,
		etag: a.etag,
		view: g.name,
		dayDelta: b,
		minuteDelta: c,
		allday: a.allDay,
		was_allday: a.was_allday,
		timezone: a.timezone,
		type: "resize"
	});
	if (get_data("formcreation") == "ok") {
		var h = $("#" + b);
		proceed_send_ajax_form(h, function(b) {
			update_single_event(a, b)
		}, function(a) {
			show_error(t("messages", "error_modfailed"), a);
			d()
		}, function() {
			d()
		})
	}
	$(h).remove()
}, event_drop_callback = function(a, b, c, d, e, f, g, h) {
	b = generate_on_the_fly_form(base_app_url + "event/alter", {
		uid: a.uid,
		calendar: a.calendar,
		etag: a.etag,
		view: h.name,
		dayDelta: b,
		minuteDelta: c,
		allday: a.allDay,
		was_allday: a.orig_allday,
		timezone: a.timezone,
		type: "drag"
	});
	if (get_data("formcreation") == "ok") {
		var i = $("#" + b);
		proceed_send_ajax_form(i, function(b) {
			update_single_event(a, b)
		}, function(a) {
			show_error(t("messages", "error_modfailed"), a);
			e()
		}, function() {
			e()
		})
	}
	$(i).remove()
}, event_delete_dialog = function() {
	var a = base_app_url + "event/delete",
		b = t("labels", "deleteevent"),
		c = get_data("current_event");
	if (c === void 0) show_error(t("messages", "error_interfacefailure"), t("messages", "error_current_event_not_loaded"));
	else return $.extend(c, {
		applyid: "event_delete_form",
		frm: {
			action: a,
			method: "post",
			csrf: get_csrf_token()
		}
	}), show_dialog("event_delete_dialog", c, b, [{
		text: t("labels", "yes"),
		"class": "addicon btn-icon-event-delete",
		click: function() {
			var a = $("#event_delete_form");
			proceed_send_ajax_form(a, function() {
				$("#calendar_view").fullCalendar("removeEvents", c.id)
			}, function() {
				show_error(t("messages", "error_event_not_deleted"), c)
			}, function() {});
			destroy_dialog("#event_delete_dialog")
		}
	}, {
		text: t("labels", "cancel"),
		"class": "addicon btn-icon-cancel",
		click: function() {
			destroy_dialog("#event_delete_dialog")
		}
	}], "event_delete_dialog", 400, function() {}), $(ved).qtip("hide"), false
}, modify_event_handler = function() {
	var a = get_data("current_event");
	if (a === void 0) show_error(t("messages", "error_interfacefailure"), t("messages", "error_current_event_not_loaded"));
	else return a = {
		uid: a.uid,
		calendar: a.calendar,
		href: a.href,
		etag: a.etag,
		start: fulldatetimestring(a.start),
		end: fulldatetimestring(a.end),
		summary: a.title,
		location: a.location,
		allday: a.allDay,
		description: a.description,
		rrule: a.rrule,
		rrule_serialized: a.rrule_serialized,
		rrule_explained: a.rrule_explained,
		icalendar_class: a.icalendar_class,
		transp: a.transp,
		recurrence_id: a.recurrence_id,
		reminders: a.reminders,
		visible_reminders: a.visible_reminders,
		orig_start: fulldatetimestring($.fullCalendar.parseDate(a.orig_start)),
		orig_end: fulldatetimestring($.fullCalendar.parseDate(a.orig_end))
	}, $(ved).qtip("hide"), event_field_form("modify", a), false
}, show_calendar = function(a) {
	$("#calendar_view").fullCalendar("addEventSource", a.data().eventsource);
	a.removeClass("transparent")
}, hide_calendar = function(a) {
	$("#calendar_view").fullCalendar("removeEventSource", a.data().eventsource);
	a.addClass("transparent")
}, toggle_calendar = function(a) {
	a.hasClass("transparent") ? show_calendar(a) : hide_calendar(a)
}, initialize_date_and_time_pickers = function(a) {
	a.find(".needs-datepicker").datepicker();
	a.find(".needs-timepicker").timePicker(AgenDAVConf.timepicker_base)
}, get_csrf_token = function() {
	return $.cookie(AgenDAVConf.prefs_csrf_cookie_name)
}, loading = function(a) {
	a === false ? $("#loading").hide() : $("#loading").show()
}, beforePrint = function() {
	$("#calendar_view").addClass("printing");
	$("#calendar_view").fullCalendar("render")
}, afterPrint = function() {
	$("#calendar_view").removeClass("printing");
	$("#calendar_view").fullCalendar("render")
}, setup_print_tweaks = function() {
	window.matchMedia && window.matchMedia("print").addListener(function(a) {
		a.matches ? beforePrint() : afterPrint()
	});
	window.onbeforeprint = beforePrint;
	window.onafterprint = afterPrint
};