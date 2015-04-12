(function() {
	dust.register("form_open", body_0);

	function body_0(chk, ctx) {
		return chk.write("<form action=\"").reference(ctx.getPath(false, ["frm", "action"]), ctx, "h").write("\" method=\"").reference(ctx.getPath(false, ["frm", "method"]), ctx, "h").write("\"").exists(ctx.get("applyclass"), ctx, {
			"block": body_1
		}, null).exists(ctx.get("applyid"), ctx, {
			"block": body_2
		}, null).write(" accept-charset=\"utf-8\"><input type=\"hidden\" name=\"").reference(ctx.get("csrf_token_name"), ctx, "h").write("\" value=\"").reference(ctx.getPath(false, ["frm", "csrf"]), ctx, "h").write("\" />");
	}
	function body_1(chk, ctx) {
		return chk.write("class=\"").reference(ctx.get("applyclass"), ctx, "h").write("\"");
	}
	function body_2(chk, ctx) {
		return chk.write(" id=\"").reference(ctx.get("applyid"), ctx, "h").write("\"");
	}
	return body_0;
})();
(function() {
	dust.register("calendar_share_access_options", body_0);

	function body_0(chk, ctx) {
		return chk.write(" <option value=\"0\"").helper("eq", ctx, {
			"block": body_1
		}, {
			"key": body_2,
			"value": "0"
		}).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "readonly"
		}).write("</option><option value=\"1\"").helper("eq", ctx, {
			"block": body_3
		}, {
			"key": body_4,
			"value": "1"
		}).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "readandwrite"
		}).write("</option>");
	}
	function body_1(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_2(chk, ctx) {
		return chk.reference(ctx.get("write_access"), ctx, "h");
	}
	function body_3(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_4(chk, ctx) {
		return chk.reference(ctx.get("write_access"), ctx, "h");
	}
	return body_0;
})();
(function() {
	dust.register("calendar_create_dialog", body_0);

	function body_0(chk, ctx) {
		return chk.write("<div id=\"calendar_create_dialog\">").partial("form_open", ctx, {
			"applyclass": "form-horizontal",
			"applyid": "calendar_create_form"
		}).partial("calendar_basic_form_part", ctx, null).partial("form_close", ctx, null).write("</div>");
	}
	return body_0;
})();
(function() {
	dust.register("form_close", body_0);

	function body_0(chk, ctx) {
		return chk.write("</form>");
	}
	return body_0;
})();
(function() {
	dust.register("calendar_delete_dialog", body_0);

	function body_0(chk, ctx) {
		return chk.write("<div id=\"calendar_delete_dialog\">").partial("form_open", ctx, null).write("<input type=\"hidden\" name=\"calendar\" value=\"").reference(ctx.get("calendar"), ctx, "h").write("\" /><p>").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_confirmcaldelete"
		}).write("</p><p><div class=\"calendar_color\" style=\"background-color: ").reference(ctx.get("color"), ctx, "h").write(";\"></div> ").reference(ctx.get("displayname"), ctx, "h").write("</p><p>").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_permanentremoval"
		}).write("</p>").partial("form_close", ctx, null).write("</div>");
	}
	return body_0;
})();
(function() {
	dust.register("reminders_table", body_0);

	function body_0(chk, ctx) {
		return chk.section(ctx.get("visible_reminders"), ctx, {
			"block": body_1
		}, null).write("<table id=\"reminders_table\" class=\"table table-striped\"><thead><th></th><th></th><th></th></thead><tbody>").section(ctx.get("reminders"), ctx, {
			"block": body_2
		}, null).write("<tr id=\"reminders_no_rows\"><td colspan=\"3\">").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_noreminders"
		}).write("</td></tr></tbody></table><span class=\"table_title\">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "newreminder"
		}).write("</span><table class=\"table\"><tbody>").partial("reminder_row", ctx, {
			"add": "true"
		}).write("</tbody></table><span class=\"table_title\">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "newreminder"
		}).write("</span><table class=\"table\"><tbody>").partial("reminder_row", ctx, {
			"add": "true",
			"is_absolute": "true"
		}).write("</tbody></table>");
	}
	function body_1(chk, ctx) {
		return chk.write("<input type=\"hidden\" name=\"visible_reminders[").reference(ctx.getPath(true, []), ctx, "h").write("]\" value=\"1\" />");
	}
	function body_2(chk, ctx) {
		return chk.partial("reminder_row", ctx, null);
	}
	return body_0;
})();
(function() {
	dust.register("calendar_share_table", body_0);

	function body_0(chk, ctx) {
		return chk.write("<table id=\"calendar_share_table\" class=\"table table-striped\"><thead><th>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "username"
		}).write("</th><th>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "access"
		}).write("</th><th></th></thead><tbody>").section(ctx.get("share_with"), ctx, {
			"block": body_1
		}, null).write("<tr id=\"calendar_share_no_rows\"><td colspan=\"3\">").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_notshared"
		}).write("</td></tr></tbody></table><span class=\"table_title\">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "sharewith"
		}).write("</span><table id=\"calendar_share_add\" class=\"table-condensed\"><tbody><tr><td><div class=\"username\"><input name=\"autocomplete_username\"class=\"input-medium\" id=\"calendar_share_add_username\"value=\"\" maxlength=\"255\" size=\"10\" /></div></td><td><select name=\"write-access\" id=\"calendar_share_add_write_access\"class=\"input-medium\">").partial("calendar_share_access_options", ctx, null).write("</select></td><td><img src=\"").reference(ctx.get("base_url"), ctx, "h").write("img/add.png\" id=\"calendar_share_add_button\"class=\"pseudobutton\"alt=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "add"
		}).write("title=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "add"
		}).write(" /></td></tr></tbody></table>");
	}
	function body_1(chk, ctx) {
		return chk.partial("calendar_share_row", ctx, null);
	}
	return body_0;
})();
(function() {
	dust.register("event_details_popup", body_0);

	function body_0(chk, ctx) {
		return chk.write("<p class=\"start_and_finish\">").reference(ctx.get("formatted_start"), ctx, "h").write(" ").reference(ctx.get("formatted_end"), ctx, "h").write("</p><dl class=\"dl-horizontal\"><dt>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "calendar"
		}).write("</dt><dd><div class=\"calendar_color\" style=\"background-color: ").reference(ctx.getPath(false, ["caldata", "color"]), ctx, "h").write(";\"></div>").reference(ctx.getPath(false, ["caldata", "displayname"]), ctx, "h").write("</dd>").exists(ctx.get("location"), ctx, {
			"block": body_1
		}, null).exists(ctx.get("description"), ctx, {
			"block": body_2
		}, null).exists(ctx.get("rrule"), ctx, {
			"block": body_3
		}, null).section(ctx.get("reminders"), ctx, {
			"block": body_7
		}, null).notexists(ctx.get("disable_actions"), ctx, {
			"block": body_8
		}, null).write("</dl>");
	}
	function body_1(chk, ctx) {
		return chk.write("<dt>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "location"
		}).write("</dt><dd>").reference(ctx.get("location"), ctx, "h").write("</dd>");
	}
	function body_2(chk, ctx) {
		return chk.write("<dt>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "description"
		}).write("</dt><dd>").reference(ctx.get("formatted_description"), ctx, "h").write("</dd>");
	}
	function body_3(chk, ctx) {
		return chk.write("<dt>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "repeat"
		}).write("</dt>").exists(ctx.get("rrule_explained"), ctx, {
			"else": body_4,
			"block": body_5
		}, null);
	}
	function body_4(chk, ctx) {
		return chk.write("<dd>").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_repetition_unparseable"
		}).write(" <spanclass=\"rrule_raw_value\">").reference(ctx.get("rrule"), ctx, "h").write("</span></dd>");
	}
	function body_5(chk, ctx) {
		return chk.write("<dd>").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_repetition_human",
			"explanation": body_6
		}).write("</dd>");
	}
	function body_6(chk, ctx) {
		return chk.reference(ctx.get("rrule_explained"), ctx, "h");
	}
	function body_7(chk, ctx) {
		return chk.write("<dt>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "reminder"
		}).write("</dt><dd>").partial("reminder_description", ctx, null).write("</dd>");
	}
	function body_8(chk, ctx) {
		return chk.write("<div class=\"actions\"><button type=\"button\" href=\"#\"class=\"addicon btn-icon-calendar-edit link_modify_event\">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "modify"
		}).write("</button><button type=\"button\" href=\"#\"class=\"addicon btn-icon-calendar-delete link_delete_event\">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "delete"
		}).write("</button></div>");
	}
	return body_0;
})();
(function() {
	dust.register("datepicker_button", body_0);

	function body_0(chk, ctx) {
		return chk.write("<span class=\"fc-header-space\" /><span class=\"fc-button-datepicker\"><i class=\"icon-calendar\" title=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "choose_date"
		}).write("\"></i></span><input type=\"hidden\" id=\"datepicker_fullcalendar\" />");
	}
	return body_0;
})();
(function() {
	dust.register("calendar_modify_dialog", body_0);

	function body_0(chk, ctx) {
		return chk.write("<div id=\"calendar_modify_dialog\"><div id=\"calendar_modify_dialog_tabs\"><ul><li><a href=\"#tabs-general\"><i class=\"tab-icon icon-tag\"></i>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "generaloptions"
		}).write("</a></li>").exists(ctx.get("enable_calendar_sharing"), ctx, {
			"block": body_1
		}, null).write("</ul>").partial("form_open", ctx, {
			"applyclass": "form-horizontal",
			"applyid": "calendar_modify_form"
		}).write("<div id=\"tabs-general\">").exists(ctx.get("user_from"), ctx, {
			"block": body_3
		}, null).partial("calendar_basic_form_part", ctx, null).write("</div>").exists(ctx.get("enable_calendar_sharing"), ctx, {
			"block": body_7
		}, null).partial("form_close", ctx, null).write("</div>");
	}
	function body_1(chk, ctx) {
		return chk.notexists(ctx.get("shared"), ctx, {
			"block": body_2
		}, null);
	}
	function body_2(chk, ctx) {
		return chk.write("<li><a href=\"#tabs-share\"><i class=\"tab-icon icon-group\"></i>").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "shareoptions"
		}).write("</a></li>");
	}
	function body_3(chk, ctx) {
		return chk.write("<div class=\"share_info ui-corner-all\">").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_sharedby",
			"user": body_4
		}).write(" ").helper("eq", ctx, {
			"block": body_5
		}, {
			"key": body_6,
			"value": "0"
		}).write("</div>");
	}
	function body_4(chk, ctx) {
		return chk.reference(ctx.get("user_from"), ctx, "h");
	}
	function body_5(chk, ctx) {
		return chk.write("(").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "readonly"
		}).write(")");
	}
	function body_6(chk, ctx) {
		return chk.reference(ctx.get("write_access"), ctx, "h");
	}
	function body_7(chk, ctx) {
		return chk.notexists(ctx.get("shared"), ctx, {
			"block": body_8
		}, null);
	}
	function body_8(chk, ctx) {
		return chk.write("<div id=\"tabs-share\">").partial("calendar_share_table", ctx, null).write("</div>");
	}
	return body_0;
})();
(function() {
	dust.register("calendar_basic_form_part", body_0);

	function body_0(chk, ctx) {
		return chk.exists(ctx.get("calendar"), ctx, {
			"block": body_1
		}, null).write("<input type=\"hidden\" name=\"is_shared_calendar\"value=\"").exists(ctx.get("shared"), ctx, {
			"else": body_2,
			"block": body_3
		}, null).write("\" />").partial("form_element_start", ctx, {
			"for": "displayname",
			"label": "displayname"
		}).write("<input name=\"displayname\" type=\"text\" size=\"25\" maxlength=\"255\" value=\"").exists(ctx.get("displayname"), ctx, {
			"block": body_4
		}, null).write("\" class=\"displayname input-medium\" />").partial("form_element_end", ctx, null).partial("form_element_start", ctx, {
			"for": "color",
			"label": "color"
		}).write("<input name=\"calendar_color\"value=\"").exists(ctx.get("color"), ctx, {
			"else": body_5,
			"block": body_6
		}, null).write("\" class=\"calendar_color pick_color input-mini\" maxlength=\"7\" size=\"7\" />").partial("form_element_end", ctx, null).exists(ctx.get("public_url"), ctx, {
			"block": body_7
		}, null);
	}
	function body_1(chk, ctx) {
		return chk.write("<input type=\"hidden\" name=\"calendar\" value=\"").reference(ctx.get("calendar"), ctx, "h").write("\" />");
	}
	function body_2(chk, ctx) {
		return chk.write("false");
	}
	function body_3(chk, ctx) {
		return chk.write("true");
	}
	function body_4(chk, ctx) {
		return chk.reference(ctx.get("displayname"), ctx, "h");
	}
	function body_5(chk, ctx) {
		return chk.reference(ctx.get("default_calendar_color"), ctx, "h");
	}
	function body_6(chk, ctx) {
		return chk.reference(ctx.get("color"), ctx, "h");
	}
	function body_7(chk, ctx) {
		return chk.write("<div class=\"public_url_container\"><i class=\"icon-link icon-large\"></i> <a href=\"").reference(ctx.get("public_url"), ctx, "h").write("\">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "publicurl"
		}).write("</p></a></div>");
	}
	return body_0;
})();
(function() {
	dust.register("form_element_start", body_0);

	function body_0(chk, ctx) {
		return chk.write("<div class=\"control-group\"><label ").exists(ctx.get("for"), ctx, {
			"block": body_1
		}, null).write("class=\"control-label\">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": ctx.get("label")
		}).write("</label><div class=\"controls\">");
	}
	function body_1(chk, ctx) {
		return chk.write("for=\"").reference(ctx.get("for"), ctx, "h").write("\"");
	}
	return body_0;
})();
(function() {
	dust.register("calendar_share_row", body_0);

	function body_0(chk, ctx) {
		return chk.write("<tr><td><span class=\"username\">").reference(ctx.get("username"), ctx, "h").write("</span></td><td><input type=\"hidden\" name=\"share_with[sid][]\" value=\"").reference(ctx.get("sid"), ctx, "h").write("\"/><input type=\"hidden\" name=\"share_with[username][]\" value=\"").reference(ctx.get("username"), ctx, "h").write("\"/><select name=\"share_with[write_access][]\" class=\"input-medium\">").partial("calendar_share_access_options", ctx, null).write("</select></td><td><img src=\"").reference(ctx.get("base_url"), ctx, "h").write("img/delete.png\" class=\"calendar_share_delete pseudobutton\" alt=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "delete"
		}).write("\"title=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "delete"
		}).write("\" /></td></tr>");
	}
	return body_0;
})();
(function() {
	dust.register("form_element_end", body_0);

	function body_0(chk, ctx) {
		return chk.exists(ctx.get("input_help"), ctx, {
			"block": body_1
		}, null).write("</div></div>");
	}
	function body_1(chk, ctx) {
		return chk.write("<p class=\"help-block\">").reference(ctx.get("input_help"), ctx, "h").write("</p>");
	}
	return body_0;
})();
(function() {
	dust.register("reminder_row", body_0);

	function body_0(chk, ctx) {
		return chk.write("<tr><td><input type=\"hidden\" name=\"").notexists(ctx.get("add"), ctx, {
			"else": body_1,
			"block": body_2
		}, null).write("\" value=\"").exists(ctx.get("is_absolute"), ctx, {
			"else": body_3,
			"block": body_4
		}, null).write("\" />").notexists(ctx.get("add"), ctx, {
			"block": body_5
		}, null).exists(ctx.get("is_absolute"), ctx, {
			"else": body_6,
			"block": body_7
		}, null).write("</td><td class=\"form-inline\">").exists(ctx.get("is_absolute"), ctx, {
			"else": body_8,
			"block": body_32
		}, null).write("</td><td>").exists(ctx.get("add"), ctx, {
			"else": body_38,
			"block": body_39
		}, null).write("</td></tr>");
	}
	function body_1(chk, ctx) {
		return chk.write("is_absolute");
	}
	function body_2(chk, ctx) {
		return chk.write("reminders[is_absolute][]");
	}
	function body_3(chk, ctx) {
		return chk.write("false");
	}
	function body_4(chk, ctx) {
		return chk.write("true");
	}
	function body_5(chk, ctx) {
		return chk.write("<input type=\"hidden\" name=\"reminders[order][]\" value=\"").reference(ctx.get("order"), ctx, "h").write("\" />");
	}
	function body_6(chk, ctx) {
		return chk.write("<i class=\"icon-time icon-large\"></i>");
	}
	function body_7(chk, ctx) {
		return chk.write("<i class=\"icon-calendar icon-large\"></i>");
	}
	function body_8(chk, ctx) {
		return chk.write("<input name=\"").notexists(ctx.get("add"), ctx, {
			"else": body_9,
			"block": body_10
		}, null).write("\" class=\"input-mini\" maxlength=\"4\" value=\"").reference(ctx.get("qty"), ctx, "h").write("\" /><select class=\"input-small\" name=\"").notexists(ctx.get("add"), ctx, {
			"else": body_11,
			"block": body_12
		}, null).write("\"><option value=\"min\"").helper("eq", ctx, {
			"block": body_13
		}, {
			"key": body_14,
			"value": "min"
		}).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "minutes"
		}).write("</option><option value=\"hour\"").helper("eq", ctx, {
			"block": body_15
		}, {
			"key": body_16,
			"value": "hour"
		}).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "hours"
		}).write("</option><option value=\"day\"").helper("eq", ctx, {
			"block": body_17
		}, {
			"key": body_18,
			"value": "day"
		}).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "days"
		}).write("</option><option value=\"week\"").helper("eq", ctx, {
			"block": body_19
		}, {
			"key": body_20,
			"value": "week"
		}).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "weeks"
		}).write("</option></select><select class=\"input-small\" name=\"").notexists(ctx.get("add"), ctx, {
			"else": body_21,
			"block": body_22
		}, null).write("\"><option value=\"true\"").exists(ctx.get("before"), ctx, {
			"block": body_23
		}, null).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "before"
		}).write("</option><option value=\"false\"").notexists(ctx.get("before"), ctx, {
			"block": body_24
		}, null).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "after"
		}).write("</option></select><select class=\"input-small\" name=\"").notexists(ctx.get("add"), ctx, {
			"else": body_26,
			"block": body_27
		}, null).write("\"><option value=\"true\"").exists(ctx.get("relatedStart"), ctx, {
			"block": body_28
		}, null).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "start"
		}).write("</option><option value=\"false\"").notexists(ctx.get("relatedStart"), ctx, {
			"block": body_29
		}, null).write(">").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "end"
		}).write("</option></select>").notexists(ctx.get("add"), ctx, {
			"block": body_31
		}, null);
	}
	function body_9(chk, ctx) {
		return chk.write("qty");
	}
	function body_10(chk, ctx) {
		return chk.write("reminders[qty][]");
	}
	function body_11(chk, ctx) {
		return chk.write("interval");
	}
	function body_12(chk, ctx) {
		return chk.write("reminders[interval][]");
	}
	function body_13(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_14(chk, ctx) {
		return chk.reference(ctx.get("interval"), ctx, "h");
	}
	function body_15(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_16(chk, ctx) {
		return chk.reference(ctx.get("interval"), ctx, "h");
	}
	function body_17(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_18(chk, ctx) {
		return chk.reference(ctx.get("interval"), ctx, "h");
	}
	function body_19(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_20(chk, ctx) {
		return chk.reference(ctx.get("interval"), ctx, "h");
	}
	function body_21(chk, ctx) {
		return chk.write("before");
	}
	function body_22(chk, ctx) {
		return chk.write("reminders[before][]");
	}
	function body_23(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_24(chk, ctx) {
		return chk.notexists(ctx.get("add"), ctx, {
			"block": body_25
		}, null);
	}
	function body_25(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_26(chk, ctx) {
		return chk.write("relatedStart");
	}
	function body_27(chk, ctx) {
		return chk.write("reminders[relatedStart][]");
	}
	function body_28(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_29(chk, ctx) {
		return chk.notexists(ctx.get("add"), ctx, {
			"block": body_30
		}, null);
	}
	function body_30(chk, ctx) {
		return chk.write(" selected=\"true\"");
	}
	function body_31(chk, ctx) {
		return chk.write("<input type=\"hidden\" name=\"reminders[tdate][]\" value=\"\" /><input type=\"hidden\" name=\"reminders[ttime][]\" value=\"\" />");
	}
	function body_32(chk, ctx) {
		return chk.write("<input type=\"text\" name=\"").notexists(ctx.get("add"), ctx, {
			"else": body_33,
			"block": body_34
		}, null).write("\" class=\"input-small needs-datepicker\" maxlength=\"10\" value=\"").reference(ctx.get("tdate"), ctx, "h").write("\" /><input type=\"text\" name=\"").notexists(ctx.get("add"), ctx, {
			"else": body_35,
			"block": body_36
		}, null).write("\" class=\"input-mini needs-timepicker\" maxlength=\"10\" value=\"").reference(ctx.get("ttime"), ctx, "h").write("\" />").notexists(ctx.get("add"), ctx, {
			"block": body_37
		}, null);
	}
	function body_33(chk, ctx) {
		return chk.write("tdate");
	}
	function body_34(chk, ctx) {
		return chk.write("reminders[tdate][]");
	}
	function body_35(chk, ctx) {
		return chk.write("ttime");
	}
	function body_36(chk, ctx) {
		return chk.write("reminders[ttime][]");
	}
	function body_37(chk, ctx) {
		return chk.write("<input type=\"hidden\" name=\"reminders[qty][]\" value=\"\" /><input type=\"hidden\" name=\"reminders[interval][]\" value=\"\" /><input type=\"hidden\" name=\"reminders[before][]\" value=\"\" />");
	}
	function body_38(chk, ctx) {
		return chk.write("<img src=\"").reference(ctx.get("base_url"), ctx, "h").write("img/delete.png\" class=\"reminder_delete pseudobutton\" alt=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "delete"
		}).write("\" title=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "delete"
		}).write("\" />");
	}
	function body_39(chk, ctx) {
		return chk.write("<img src=\"").reference(ctx.get("base_url"), ctx, "h").write("img/add.png\" class=\"reminder_add_button pseudobutton\" alt=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "add"
		}).write("\" title=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "add"
		}).write("\" />");
	}
	return body_0;
})();
(function() {
	dust.register("event_delete_dialog", body_0);

	function body_0(chk, ctx) {
		return chk.write("<div id=\"event_delete_dialog\">").partial("form_open", ctx, null).write("<input type=\"hidden\" name=\"calendar\" value=\"").reference(ctx.get("calendar"), ctx, "h").write("\" /><input type=\"hidden\" name=\"uid\" value=\"").reference(ctx.get("uid"), ctx, "h").write("\" /><input type=\"hidden\" name=\"href\" value=\"").reference(ctx.get("href"), ctx, "h").write("\" /><input type=\"hidden\" name=\"etag\" value=\"").reference(ctx.get("etag"), ctx, "h").write("\" /><p>").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_confirmeventdelete"
		}).write("</p><p class=\"title\">").reference(ctx.get("title"), ctx, "h").write("</p>").exists(ctx.get("rrule"), ctx, {
			"block": body_1
		}, null).partial("form_close", ctx, null).write("</div>");
	}
	function body_1(chk, ctx) {
		return chk.write("<p>").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_repetitivedeleteall"
		}).write("</p>");
	}
	return body_0;
})();
(function() {
	dust.register("calendar_list_entry", body_0);

	function body_0(chk, ctx) {
		return chk.write("<li class=\"available_calendar").exists(ctx.get("default_calendar"), ctx, {
			"block": body_1
		}, null).write("\"><div class=\"calendar_color\" style=\"background-color:").exists(ctx.get("color"), ctx, {
			"else": body_2,
			"block": body_3
		}, null).write("; border-color: ").reference(ctx.get("bordercolor"), ctx, "h").write("\"></div><span class=\"icons\">").exists(ctx.get("shared"), ctx, {
			"else": body_4,
			"block": body_6
		}, null).write("</span><span class=\"text\"").exists(ctx.get("user_from"), ctx, {
			"block": body_9
		}, null).write(">").reference(ctx.get("displayname"), ctx, "h").write("</span><i title=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "modifycalendar"
		}).write("\" class=\"cfg pseudobutton icon-cogs\"></i></li>");
	}
	function body_1(chk, ctx) {
		return chk.write(" default_calendar");
	}
	function body_2(chk, ctx) {
		return chk.reference(ctx.get("default_calendar_color"), ctx, "h");
	}
	function body_3(chk, ctx) {
		return chk.reference(ctx.get("color"), ctx, "h");
	}
	function body_4(chk, ctx) {
		return chk.exists(ctx.get("share_with"), ctx, {
			"block": body_5
		}, null);
	}
	function body_5(chk, ctx) {
		return chk.write("<i title=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "currentlysharing"
		}).write("\" class=\"icon-share\"></i>");
	}
	function body_6(chk, ctx) {
		return chk.helper("eq", ctx, {
			"block": body_7
		}, {
			"key": body_8,
			"value": "0"
		});
	}
	function body_7(chk, ctx) {
		return chk.write("<i title=\"").helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "readonly"
		}).write("\" class=\"icon-lock\"></i>");
	}
	function body_8(chk, ctx) {
		return chk.reference(ctx.get("write_access"), ctx, "h");
	}
	function body_9(chk, ctx) {
		return chk.write("title=\"").helper("i18n", ctx, {}, {
			"type": "messages",
			"name": "info_sharedby",
			"user": body_10
		}).write("\"");
	}
	function body_10(chk, ctx) {
		return chk.reference(ctx.get("user_from"), ctx, "h");
	}
	return body_0;
})();
(function() {
	dust.register("reminder_description", body_0);

	function body_0(chk, ctx) {
		return chk.exists(ctx.get("is_absolute"), ctx, {
			"else": body_1,
			"block": body_12
		}, null);
	}
	function body_1(chk, ctx) {
		return chk.reference(ctx.get("qty"), ctx, "h").write(" ").helper("select", ctx, {
			"block": body_2
		}, {
			"key": body_7
		}).write(" ").exists(ctx.get("before"), ctx, {
			"else": body_8,
			"block": body_9
		}, null).write(" ").exists(ctx.get("relatedStart"), ctx, {
			"else": body_10,
			"block": body_11
		}, null);
	}
	function body_2(chk, ctx) {
		return chk.helper("eq", ctx, {
			"block": body_3
		}, {
			"value": "min"
		}).helper("eq", ctx, {
			"block": body_4
		}, {
			"value": "hour"
		}).helper("eq", ctx, {
			"block": body_5
		}, {
			"value": "day"
		}).helper("eq", ctx, {
			"block": body_6
		}, {
			"value": "week"
		});
	}
	function body_3(chk, ctx) {
		return chk.helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "minutes"
		});
	}
	function body_4(chk, ctx) {
		return chk.helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "hours"
		});
	}
	function body_5(chk, ctx) {
		return chk.helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "days"
		});
	}
	function body_6(chk, ctx) {
		return chk.helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "weeks"
		});
	}
	function body_7(chk, ctx) {
		return chk.reference(ctx.get("interval"), ctx, "h");
	}
	function body_8(chk, ctx) {
		return chk.helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "after"
		});
	}
	function body_9(chk, ctx) {
		return chk.helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "before"
		});
	}
	function body_10(chk, ctx) {
		return chk.helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "end"
		});
	}
	function body_11(chk, ctx) {
		return chk.helper("i18n", ctx, {}, {
			"type": "labels",
			"name": "start"
		});
	}
	function body_12(chk, ctx) {
		return chk.reference(ctx.get("tdate"), ctx, "h").write(" ").reference(ctx.get("ttime"), ctx, "h");
	}
	return body_0;
})();