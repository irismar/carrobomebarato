// Copyright 2001-2005 Interakt Online. All rights reserved.
var is = new BrowserCheck();

if (typeof utility == 'undefined') utility = {};
/*
utility = {
	'math': {},
	'string': {}, 
	'js': {}, 
	'debug': {}, 
	'url': {},
	'dom': {},
	'window': {}, 
	'cookie': {}, 
	'date': {}, 
	'req': {}, 
	'xml': {}
};
*/

Object_weave_safe(utility, {math: {}});

utility.math.intbgr2hexrgb = function(a) {
	d2h = utility.math.dec2hex;
	pad = utility.math.zeroPad;
	// on mozilla will report rgb(a, b, c) - so the following is not good
	return "#" + pad(d2h(a % 256), 2) + pad(d2h((a / 256) % 256), 2) + pad(d2h((a / 65536) % 256), 2);
}

utility.math.mozcolor2rgb = function(color) {
	return color;
}

utility.math.dec2hex = function(x) {
	return Number(parseInt(x)).toString(16);
}

utility.math.hex2dec = function(x) {
	return parseInt(x, 16);
}

utility.math.zeroPad = function (str, length) {
	if (!str) str = "";
	str = str.toString();
	while (str.length < length) {
		str = "0" + str;
	}
	return str;
}

Object_weave_safe(utility, {js: {}});

utility.js.build = function(fun1, fun2) {
	var me = function() {
		if (fun2) { fun2(); }
		if (fun1) { fun1(); }
	}
	return me;
}
utility.js.empty_func = function() {};

Object_weave_safe(utility, {debug: {}});

utility.debug.dump = function (obj, sep) {
	if (sep == undefined) {
		sep = '';
	}
	tm = "";
	if (typeof (obj) == "object") {
		for (i in obj) {
			tm += sep + i + ":{\n" + utility.debug.dump(obj[i], sep + '  ') + "}\n";
		}
		return tm;
	}
	if (typeof (obj) == "function") return sep + typeof (obj) + "\n";
	return sep + obj + "\n";
}

utility.debug.dumpone = function (obj, sep) {
	if (sep == undefined) {
		sep = '';
	}
	tm = "";
	if (typeof (obj) == "object") {
		for (i in obj) {
			if (typeof obj[i] != 'function') {
				tm += sep + i + ":{\n" + obj[i] + "}\n";
			} else {
				//tm += sep + i + ":{\n js function }\n";
			}
		}
		return tm;
	}
	if (typeof (obj) == "function") return sep + typeof (obj) + "\n";
	return sep + obj + "\n";
}

utility.debug.breakpoint = function(evalFunc, msg, initialExprStr) { 
	if (evalFunc == null) 
		evalFunc = function(e){return eval(e)};
    if (msg == null)
        msg = "";
    var result = initialExprStr || "1+2";
    while (true) {
        var expr = prompt("BREAKPOINT: " + msg + "\nEnter an expression to evaluate, or Cancel to continue.", result); 
        if (expr == null || expr == "")
            return;
        try {
            result = evalFunc(expr);
        } catch (e) {
            result = e;
        }
    }
}

Object_weave_safe(utility, {string: {}});

utility.string.htmlspecialchars = function(str) {
	Array_each([	['>', '&gt;'],
		['<', '&lt;'],
		['\xA0', '&nbsp;'],
		['"', '&quot;']
	], function(repl, idx) {
		str = str.replace(new RegExp('['+repl[0]+']', "g"), repl[1]);
	});
	return str;
}

utility.string.getInnerText = function(str) {
	if (typeof getInnerText_tmpDiv == 'undefined') {
		getInnerText_tmpDiv = document.createElement('div');
	}
	var oldstr = str;
	try {
		getInnerText_tmpDiv.innerHTML = str;
		if (is.safari) {
			str = getInnerText_tmpDiv.innerHTML;
		} else {
			str = getInnerText_tmpDiv.innerText;
		}
	} catch(e) { return oldstr; } 
	if ( typeof str == 'undefined') {
		return oldstr;
	}
	return str;
}

utility.string.sprintf = function() {
	if (!arguments || arguments.length < 1 || !RegExp) {
		return;
	}

	var str = arguments[0];
	var oldstr = arguments[0];
	var re = /([^%]*)%('.|0|\x20)?(-)?(\d+)?(\.\d+)?(%|b|c|d|u|f|o|s|x|X)(.*)/;
	var a = b = [], numSubstitutions = 0, numMatches = 0;
	while (a = re.exec(str)) {
		var leftpart = a[1], pPad = a[2], pJustify = a[3], pMinLength = a[4];
		var pPrecision = a[5], pType = a[6], rightPart = a[7];
		numMatches++;

		if (pType == '%') {
			subst = '%';
		} else {
			numSubstitutions++;
			if (numSubstitutions >= arguments.length) {
				return oldstr;
			}
			var param = arguments[numSubstitutions];
			var subst = param;

			if (pType == 'c') subst = String.fromCharCode(parseInt(param));
			else if (pType == 'd') subst = parseInt(param) ? parseInt(param) : 0;
			else if (pType == 's') subst = param;
		}
		str = leftpart + subst + rightPart;
	}
	return str;
}

Object_weave_safe(utility, {dom: {}});


utility.dom.setUnselectable = function(el) {
	if (is.ie) {
		if(el.nodeType == 1) {
			if (el.tagName == 'INPUT') {
				if(el.type && el.type.toLowerCase() != 'image') {
					return;
				}
			}
			el.unselectable = 'on';
			if (el.childNodes && el.childNodes.length) {
				for (var i=0;i<el.childNodes.length;i++) {
					utility.dom.setUnselectable(el.childNodes[i]);
				}
			}
		}
	} else if (is.mozilla) {
		el.style.setProperty('-moz-user-focus','ignore','');
		el.style.setProperty('-moz-user-select','none','');
	}
}

utility.dom.put = function(el, left, top) {
	el.style.left = left + 'px';
	el.style.top = top + 'px';
}

utility.dom.resize = function(el, width, height) {
	el.style.width = width + 'px';
	el.style.height = height + 'px';
}

utility.dom.focusElem =function(elem) {
	var d;
	d = this.getElem(elem);
	if (!d) return;
	if (d.focus) d.focus();
}

utility.dom.hideElem = function(elem) {
	this.setCssProperty(elem, "display", "none");
}

utility.dom.showElem = function(elem, force) {
	var tag_display = {
		table: 'table',
		tr: 'table-row',
		td: 'table-cell'
	}
	elem = utility.dom.getElem(elem);
	var tn = elem.tagName.toLowerCase();
	var t;
	if (!force) {
		if (typeof tag_display[tn] != 'undefined') {
			t = tag_display[tn];
		} else {
			t = "block";
		}
	} else {
		t = 'force';
	}
	try {
		this.setCssProperty(elem, "display", t);
	} catch(e) {
		// default to block if first try doesn't work
		// this happens on explorer when trying to set table-row and friends
		this.setCssProperty(elem, "display", "block");
	}
}

// because we can't find out on the first call the real state, we assume the element is hidden
utility.dom.toggleElem = function(elem, force) {
	elem = utility.dom.getElem(elem);
	try {
		if (!elem.style.display || elem.style.display == 'none') {
			utility.dom.showElem(elem, force);
		} else {
			utility.dom.hideElem(elem);
		}
	} catch(e) { }
}

// select the option that has the given value
utility.dom.selectOption = function(sel, val) {
	var i;
	if (!sel) return;
	for (i=0; i<sel.options.length; i++) {
		sel.options[i].removeAttribute('selected');
	}
	for (i=0; i<sel.options.length; i++) {
		if (sel.options[i].value == val) {
			sel.options[i].setAttribute('selected','selected');
			sel.options[i].selected = true;
			return;
		} else {
			sel.options[i].removeAttribute('selected');
		}
	}
}

// get value of the selected option
utility.dom.getSelected = function(sel) {
	return sel.options[sel.selectedIndex].value;
}



utility.dom.getPositionRelativeTo00 = function(x, y, w, h) {
	var bw, bh, sw, sh, d;
	if (is.mozilla) {
		bw = document.width;
		bh = document.height;
		sw = window.pageXOffset;
		sh = window.pageYOffset;
	} else {
		d = document.body;
		bw = d.offsetWidth - 20;
		bh = d.offsetHeight;
		sw = d.scrollLeft;
		sh = d.scrollTop;
	}
	if (x + w > bw + sw) {
		x = bw + sw - w;
	}
	if (y + h > bh + sh) {
		y = bh + sh - h;
	}
	if (x < 0) x = 0;
	if (y < 0) y = 0;
	return { x: x, y: y };
}
utility.dom.setCssProperty = function(elem, name, value) {
	var d;
	// sanity
	if (!elem || !name || !value) return;
	d = this.getElem(elem);
	if (!d) return;
	d.style[name] = value;
}

utility.dom.getElem = function(elem) {
	var d;
	if (typeof(elem) == "string") {
		d = document.getElementById(elem);
	} else {
		d = elem;
	}
	return d;
}

// return 
utility.dom.getClassNames = function(o) {
	o = utility.dom.getElem(o);
	if (!o) return false;
	var cn = String_trim(String_normalize_space(o.className));
	if (cn == '') {
		return [];
	}
	return cn.split(" ");
}

utility.dom.classNameAdd = function(obj, toadd) {
	var cls = utility.dom.getClassNames(obj);
	if (typeof toadd == 'string') {
		toadd = toadd.split(',');
	}
	Array_each(toadd, function(item, i){
		if (Array_indexOf(cls, item) == -1) {
			Array_push(cls, item);
		}
	});
	cls = String_trim(cls.join(' '));
	if (String_trim(obj.className) != cls) {
		obj.className = cls;
	}
}

utility.dom.classNameRemove = function(obj, toremove) {
	var cls = utility.dom.getClassNames(obj);
	var result = [];
	/* can't use ruby.js and all those nice things yet 
	 * since ie5 doesn't have .hasOwnProperty
	cls = cls.reject(function(item, i) {
		return (item == str);
	});
	*/
	if (typeof toremove == 'string') {
		toremove = toremove.split(',');
	}
	Array_each(cls, function(item, i){
		if (Array_indexOf(toremove, item) == -1) {
			Array_push(result, item);
		}
	});
	
	cls = String_trim(result.join(' '));
	if (String_trim(obj.className) != cls) {
		obj.className = cls;
	}
}

utility.dom.insertAfter = function(newElement, targetElement) {
	var sibling = targetElement.nextSibling
	var parent = targetElement.parentNode;
	if (sibling == null) {
		var toret = parent.appendChild(newElement);
	} else {
		var toret = parent.insertBefore(newElement, sibling);
	}
	return toret;
}

utility.dom.getNextSiblingByTagName = function(t, siblingName) {
	if (t.nodeName.toLowerCase() == siblingName.toLowerCase()) {
		return t;
	}

	while (t.nextSibling
			&& t.nextSibling.nodeName.toLowerCase() != siblingName.toLowerCase()
			) {
		t = t.nextSibling;
	}

	if (t.nextSibling && t.nextSibling.nodeName.toLowerCase() == siblingName.toLowerCase()) {
		return t.nextSibling;
	} else {
		return null;
	}
}


utility.dom.getParentByTagName = function(t, parentName) {
	if (t.nodeName.toLowerCase() == parentName.toLowerCase()) {
		return t;
	}

	while (t.parentNode
			&& t.parentNode.nodeName.toLowerCase() != parentName.toLowerCase()
			&& t.parentNode.nodeName != 'BODY') {
		t = t.parentNode;
	}

	if (t.parentNode && t.parentNode.nodeName.toLowerCase() == parentName.toLowerCase()) {
		return t.parentNode;
	} else {
		return null;
	}
}

// should refactor this to take the tagname as a list or array of tagnames
// TODO : parameter order
utility.dom.getElementsByTagName = function(o, sTagName) {
	var el;
	if (typeof o == 'undefined') {
		o = document;
	} else {
		o = utility.dom.getElem(o);
	}

	if (sTagName == '*' || typeof sTagName == 'undefined') {
		el = utility.dom.getAllChildren(o);
	} else {
		el = o.getElementsByTagName(sTagName.toLowerCase());
	}
	return el;
}

// actually, this should be a front for a more generic method that gets elements filtered by an attribute
// or, we should try to use more of ruby.js to make this things easier to do (include Enumerable)
utility.dom.getElementsByClassName = function(o, sClassName, sTagName) {
	var elements = [];
	Array_each(utility.dom.getElementsByTagName(o, sTagName), function(elem, i) {
		if (Array_indexOf(utility.dom.getClassNames(elem), sClassName) != -1) { 
			Array_push(elements, elem);
		}
	});
	return elements;
}

utility.dom.getElementById = function(o, sId, sTagName) {
	var elements = [];
	Array_each(utility.dom.getElementsByTagName(o, sTagName), function(elem, i) {
		if (typeof elem.id != "undefined" && elem.id != null && elem.id.toString() == sId) { 
			Array_push(elements, elem);
		}
	});
	return elements;
}

utility.dom.getElementsByProps = function(start, props_hash) {
	var unfiltered, toret = [];
	if (typeof(start) == 'undefined') {
		start = document;
	} else {
		start = utility.dom.getElem(o);
	}
	if (o.all) {
		unfiltered = o.all;
	} else {
		unfiltered = o.getElementsByTagName('*');
	}
	//unfiltered.each = Array.prototype.each;
	Array_each(unfiltered, function(item) {
		var cond = true;
		for (i in props_hash) {
			try {
				var value = item[i];
			} catch(e) { value = null; }
			cond = cond && (value == props_hash[i]);
		}
		if (cond) {
			Array_push(toret, item);
		}
	});
	return toret;
}

// get all children of elem that have the "tag" tagName
utility.dom.getChildrenByTagName = function(elem, tag) {
	var result = [];
	var x;
	if (typeof(tag) == 'undefined') tag = '*';
	tag = tag.toLowerCase();
	if (!elem.childNodes) return result;
	for (var i=0; i<elem.childNodes.length; i++) {
		x = elem.childNodes[i];
		try {
			if (
				(typeof(x) != 'undefined' && 
				typeof(x.tagName) != 'undefined' && 
				x.tagName.toLowerCase() == tag) || tag == '*'
				
			) {
				Array_push(result, x);
			}
		} catch(e) { 
			// nick the error 
		}
	}
	return result;
}

// get all children of elem that have the class "sClassName"
// sTagName is optional, defaults to *
utility.dom.getChildrenByClassName = function(elem, sClassName, sTagName) {
	var result = [];
	result = Array_each(utility.dom.getChildrenByTagName(sTagName), function(elem, i) {
		if (Array_indexOf(utility.dom.getClassNames(item), sClassName) != -1) { 
			Array_push(result, elem);
		}
	});
}

utility.dom.getAllChildren = function(e) {
	// Returns all children of element. Workaround required for IE5/Windows. Ugh.
	return e.all ? e.all : e.getElementsByTagName('*');
}

utility.dom.getElementsBySelector = function(selector, startfrom) {
	if (typeof startfrom == 'undefined') {
		startfrom = document;
	}

	if (!document.getElementsByTagName) {
		return [];
	}
	// Split selector in to tokens
	var tokens = selector.split(' ');
	var currentContext = new Array(startfrom);
	for (var i = 0; i < tokens.length; i++) {
		token = tokens[i].replace(/^\s+/,'').replace(/\s+$/,'');
		if (token.indexOf('#') > -1) {
			// Token is an ID selector
			var bits = token.split('#');
			var tagName = bits[0];
			var id = bits[1];
			var element = document.getElementById(id);
			if (element && tagName && element.nodeName.toLowerCase() != tagName) {
				// tag with that ID not found, return false
				return [];
			}
			// Set currentContext to contain just this element
			currentContext = new Array(element);
			continue; // Skip to next token
		}
		if (token.indexOf('.') > -1) {
			// Token contains a class selector
			var bits = token.split('.');
			var tagName = bits[0];
			var className = bits[1];
			if (!tagName) {
				tagName = '*';
			}
			// Get elements matching tag, filter them for class selector
			var found = new Array;
			var foundCount = 0;
			for (var h = 0; h < currentContext.length; h++) {
				var elements;
				if (tagName == '*') {
					elements = utility.dom.getAllChildren(currentContext[h]);
				} else {
					elements = currentContext[h].getElementsByTagName(tagName);
				}
				for (var j = 0; j < elements.length; j++) {
				  found[foundCount++] = elements[j];
				}
			}
			currentContext = new Array;
			var currentContextIndex = 0;
			for (var k = 0; k < found.length; k++) {
				if (found[k].className && found[k].className.match(new RegExp('\\b'+className+'\\b'))) {
				  currentContext[currentContextIndex++] = found[k];
				}
			}
			continue; // Skip to next token
		}
		// Code to deal with attribute selectors
		if (token.match(/^(\w*)\[(\w+)([=~\|\^\$\*]?)=?"?([^\]"]*)"?\]$/)) {
			var tagName = RegExp.$1;
			var attrName = RegExp.$2;
			var attrOperator = RegExp.$3;
			var attrValue = RegExp.$4;
			if (!tagName) {
				tagName = '*';
			}
			// Grab all of the tagName elements within current context
			var found = new Array;
			var foundCount = 0;
			for (var h = 0; h < currentContext.length; h++) {
				var elements;
				if (tagName == '*') {
					elements = utility.dom.getAllChildren(currentContext[h]);
				} else {
					elements = currentContext[h].getElementsByTagName(tagName);
				}
				for (var j = 0; j < elements.length; j++) {
					found[foundCount++] = elements[j];
				}
			}
			currentContext = new Array;
			var currentContextIndex = 0;
			var checkFunction; // This function will be used to filter the elements
			switch (attrOperator) {
				case '=': // Equality
					checkFunction = function(e) { try {return (e.getAttribute(attrName).toString() == attrValue);} catch(ex) { } };
				break;
				case '~': // Match one of space seperated words 
					checkFunction = function(e) { try {return (e.getAttribute(attrName).toString().match(new RegExp(attrValue)));} catch(ex) { return false; }  };
				break;
				case '|': // Match start with value followed by optional hyphen
					checkFunction = function(e) { return (e.getAttribute(attrName).toString().match(new RegExp('^'+attrValue+'-?'))); };
				break;
				case '^': // Match starts with value
					checkFunction = function(e) { return (e.getAttribute(attrName).toString().indexOf(attrValue) == 0); };
				break;
				case '$': // Match ends with value - fails with "Warning" in Opera 7
					checkFunction = function(e) { return (e.getAttribute(attrName).toString().lastIndexOf(attrValue) == e.getAttribute(attrName).length - attrValue.length); };
				break;
				case '*': // Match ends with value
					checkFunction = function(e) { return (e.getAttribute(attrName).toString().indexOf(attrValue) > -1); };
				break;
				default :
					// Just test for existence of attribute
					checkFunction = function(e) { return e.getAttribute(attrName); };
			}
			currentContext = new Array;
			var currentContextIndex = 0;
			for (var k = 0; k < found.length; k++) {
				if (checkFunction(found[k])) {
					currentContext[currentContextIndex++] = found[k];
				}
			}
			//alert('Attribute Selector: '+tagName+' '+attrName+' '+attrOperator+' '+attrValue);
			continue; // Skip to next token
		}
		// If we get here, token is JUST an element (not a class or ID selector)
		tagName = token;
		var found = new Array;
		var foundCount = 0;
		for (var h = 0; h < currentContext.length; h++) {
			if (currentContext[h] != null) {
				var elements = currentContext[h].getElementsByTagName(tagName);
				for (var j = 0; j < elements.length; j++) {
					found[foundCount++] = elements[j];
				}
			}
		}
		currentContext = found;
	}
	return currentContext;
}

utility.dom.createForm = function(options, inputs, doc) {
	if (typeof options == 'undefined') options = {};
	if (typeof inputs == 'undefined') inputs = [];
	if (typeof doc == 'undefined') doc = document;

	var default_options = {
		name: '', 
		id: '', 
		action: '',
		method: 'POST', // form method
		target: ''
	}

	options = Object_weave_safe(options, default_options);

	var frm = utility.dom.createElement( "FORM", {
		name: options.name, 
		id: options.id, 
		action: options.action, 
		method: options.method, 
		style: "display: none"
	});

	Array_each(inputs, function(input, i) {
		frm.appendChild(utility.dom.createElement('INPUT', {
			'type': 'hidden', 
			'id': input[0], 
			'name': input[0], 
			'value': input[1]
		}));
	});

	frm = doc.body.appendChild(frm);
	frm.target = options.target;
	return frm;
}

utility.dom.createIframe = function(options, doc) {
	if (typeof options == 'undefined') options = {};
	if (typeof doc == 'undefined') doc = document;

	var default_options = {
		name: '', 
		id: '', 
		src: 'about:blank'
	}

	options = Object_weave_safe(options, default_options);

	if (is.mozilla) {
		var ifr = utility.dom.createElement('iframe', {
			'id': options.id, 
			'name': options.name, 
			'style': 'display: none;'
		});
		ifr.src = options.src;
		ifr = doc.body.appendChild(ifr);
		ifr.name = options.name;
		ifr.id = options.id;
	} else if (is.ie) {
		var str = '<iframe name="'+options.name+'" id="'+options.id+'" style="display:block;"></iframe>';
		var dv = doc.createElement('div');
		dv = doc.body.appendChild(dv);
		dv.innerHTML = str;
	}
	var ifr = doc.getElementById(options.id);
	return ifr;
}

utility.dom.addIframeLoad = function(ifr, functor) {
	if (is.mozilla) {
		ifr.onload = function() {
			functor();
		}
	} else {
		ifr.onreadystatechange = function() {
			if (ifr.readyState == 'complete') {
				functor();
			}
		}
	}
}

utility.dom.removeIframeLoad = function(ifr) {
	if (is.ie) { ifr.onreadystatechange = function() { }; }
	if (is.mozilla) {ifr.onload = function() { }; }
}

utility.dom.buildUrl = function() {
}

utility.dom.stripAttributes = function(el, additional_arr) {
	var cearElementProps = [
		'onload', 'data', 'onmouseover', 'onmouseout', 'onmousedown', 
		'onmouseup', 'ondblclick', 'onclick', 'onselectstart', 
		'oncontextmenu', 'onkeydown',   'onkeypress', 'onkeyup',
		'onblur', 'onfocus', 'onbeforedeactivate', 'onchange'];
	if (typeof el == 'undefined' || el == null) {
		return true;
	}
	for (var c = cearElementProps.length; c--; ) {
		el[cearElementProps[c]] = null;
	}
	if (typeof additional_arr != 'undefined') {
		for (var c = additional_arr.length; c--; ) {
			el[additional_arr[c]] = null;
		}
	}
}
// use attachEvent for ie
utility.dom.attachEvent2 = function(where, type, what, when) {
	utility.dom.attachEvent_base(where, type, what, when, 1);
}
// use on. for ie
utility.dom.attachEvent = function(where, type, what, when) {
	utility.dom.attachEvent_base(where, type, what, when, 0);
}

// don't use attachEvent for ie since we can't get 
// to the element where the handler is added from the handler
utility.dom.attachEvent_base = function(where, type, what, when, useAdvancedModel) {
	function treatType(type) {
		//mozilla events are without 'on'
		if (typeof document.addEventListener != 'undefined') {
			type = type.replace(/^on/, '');
		} else if (typeof document.attachEvent != 'undefined' && !type.match(/^on/)) {
			type = 'on' + type;
		}

		return type;
	}

	if (typeof(when) == 'undefined') when = 1;
	if (typeof(useAdvancedModel) == 'undefined') useAdvancedModel = 0;

	type = treatType(type);

	var oldHandler = null;

	try {
		if (where['on' + type.replace(/^on/, '')] != null && 
			typeof where['on' + type.replace(/^on/, '')] != "undefined") {
			
			oldHandler = where['on' + type.replace(/^on/, '')];
		} else {
			oldHandler = function() { };
		}
	} catch(e) { }

	if (when == 0) {
		var built_function = function(e) {
			if (typeof e == 'undefined') { e = window.event; }
			what.call(where, e); 
			oldHandler.call(where, e); 
		}
	} else {
		var built_function = function(e) {
			if (typeof e == 'undefined') { e = window.event; }
			oldHandler.call(where, e); 
			what.call(where, e); 
		}
	}

	var doNotAdd = type.match(/unload$/i);
	
	if (useAdvancedModel) {
		//we don't care : that you need "this" in the handler, that you already have other handlers etcetera. 
		if (typeof where.addEventListener != 'undefined') {   //Mozilla
			where.addEventListener(type, what, false);
		} else if (typeof where.attachEvent != 'undefined') { //IE
			where.attachEvent(type, what);
		} else {
			where['on' + type.replace(/^on/, '')] = what;
		}
		if ( (! (is.ie && is.mac)) && !doNotAdd) {
			EventCache.add(where, 'on' + type.replace(/^on/, ''), what, 1);
		}
	} else {
		where['on' + type.replace(/^on/, '')] = built_function;
		if ( (! (is.ie && is.mac)) && !doNotAdd) {
			EventCache.add(where, 'on' + type.replace(/^on/, ''), built_function, 1);
		}
	}
	// add the event
}

var EventCache = function(){
	var listEvents = [];
	
	return {
		listEvents : listEvents,
	
		add : function(node, sEventName, fHandler, bCapture){
			listEvents.push(arguments);
		},
	
		flush : function(){
			var i, item;
			for(i = listEvents.length - 1; i >= 0; i = i - 1){
				item = listEvents[i];
				
				if(item[0].removeEventListener){
					item[0].removeEventListener(item[1], item[2], item[3]);
				};
				
				/* From this point on we need the event names to be prefixed with 'on" */
				if(item[1].substring(0, 2) != "on"){
					item[1] = "on" + item[1];
				};
				
				if(item[0].detachEvent){
					item[0].detachEvent(item[1], item[2]);
				};
				
				item[0][item[1]] = null;
			};
		}
	};
}();


utility.dom.getStyleProperty = function(el, property) {
	var value = el.style[property];

	if (!value) {
		if (document.defaultView && 
			typeof (document.defaultView.getComputedStyle) == "function") { 
			// moz, opera
			value = document.defaultView.getComputedStyle(el, "").getPropertyValue(property);
		} else if (el.currentStyle) {
			// IE
			value = el.currentStyle[property];
		} else if (el.style) {
			value = el.style[property];
		}
	}

	return value;
}

utility.dom.getLink = function(link) {
	if (!is.ie) {
		href = link.getAttribute('href');
	} else {
		if (!is.mac) {
			href = link.outerHTML.toString().replace(/.*href="([^"]*)".*/, "$1");
		} else {
			href = link.getAttribute('href');
		}
	}
	return href;
}

utility.dom.getDisplay = function(el) {
	return utility.dom.getStyleProperty(el, 'display');
}

utility.dom.getVisibility = function(el) {
	return utility.dom.getStyleProperty(el, 'visibility');
}
var first_getAbsolutePos_caller_element = null;
utility.dom.getAbsolutePos = function(el) {
	var scrollleft = 0, scrolltop = 0, tn = el.tagName.toUpperCase();
	if (utility.dom.getAbsolutePos.caller!=utility.dom.getAbsolutePos) {
		//do not substract the scrollLeft of the target element if you want to find it's left...
		first_getAbsolutePos_caller_element = el;
	}
	if (Array_indexOf(['BODY', 'HTML'], tn) == -1 && first_getAbsolutePos_caller_element!=el) { // ?
		if (el.scrollLeft) {
			scrollleft = el.scrollLeft;
		}

		if (el.scrollTop) {
			scrolltop = el.scrollTop;
		}
	}

	var r = { x: el.offsetLeft - scrollleft, y: el.offsetTop - scrolltop };

	if (el.offsetParent && tn != 'BODY') {
		var tmp = utility.dom.getAbsolutePos(el.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
	}

	return r;
}

utility.dom.setEventVars = function(e) {
	var targ, relTarg, posx = 0, posy = 0;

	if (!e){
		e = window.event;
	}

	if (e.relatedTarget) relTarg = e.relatedTarget;
	else if (e.fromElement) relTarg = e.fromElement;

	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;

	var st = utility.dom.getPageScroll();

	//position
	if (e.pageX || e.pageY) {
		posx = e.pageX;
		posy = e.pageY;
	} else if (e.clientX || e.clientY) {
		posx = e.clientX + st.x;
		posy = e.clientY + st.y;
	}

	//mouse button
	if (window.event) {
		var leftclick = (e.button == 1);
		var middleclick = (e.button == 4);
		var rightclick = (e.button == 2);
	} else {
		var leftclick = (e.button == 0);
		var middleclick = (e.button == 1);
		var rightclick = (e.button == 2 || e.button == 0 && is.mac && e.ctrlKey);
	}

	o = { 'e': e,
		'relTarg': relTarg,
		'targ': targ,
		'posx': posx, 'posy': posy,
		'leftclick': leftclick, 
		'middleclick': middleclick, 
		'rightclick': rightclick, 
		'type': e.type };

	return o;
}

utility.dom.stopEvent = function(e) {
	if (typeof is == 'undefined') {
		is = new BrowserCheck();
	}
	if (typeof e != "undefined") {
		if(is.ie) {
			e.cancelBubble = true;
		} 
		if (e.stopPropagation) {
			e.stopPropagation();
		}

		if(is.ie) {
			e.returnValue = false;
		}
		if (e.preventDefault) {
			e.preventDefault();
		}
	}
	return false;
}

utility.dom.toggleSpecialTags = function(el, exclude, mode) {
	//var t1 = new Date();
	var hide_tags = ['select'];
	if (mode==1) {
		var boxObject = utility.dom.getBox(el);
	}
	for (var i = 0; i < hide_tags.length; i++) {
		var arr = document.getElementsByTagName(hide_tags[i]);

		for (var j = 0; j < arr.length; j++) {
			if (exclude == arr[j]) {
				continue;
			}
			if (mode == 1) {
				var cVisibility = utility.dom.getVisibility(arr[j]);
				var cDisplay = utility.dom.getDisplay(arr[j]);
				if (cDisplay=="none" || cVisibility=="hidden") {
					continue;
				}
				var boxSelect = utility.dom.getBox(arr[j]);
				var overlap = utility.dom.boxOverlap(boxObject, boxSelect);
				if (overlap) {
					//hide overlaped
					if (!arr[j].oldvisibility) {
						arr[j].oldvisibility = cVisibility;
					}
					arr[j].style.visibility = 'hidden';
				}
			} else {
				//restore
				if (arr[j].oldvisibility) {
					arr[j].style.visibility = arr[j].oldvisibility;
				}
			}
		}
	}
}

utility.dom.boxOverlap = function(b1, b2) {
	//boxes do not overlap when b1:
	//is in the left of b2
	//or in the right of b2
	//or above b2
	//or below b2

	if( (b1.x+b1.width) < b2.x || b1.x > (b2.x+b2.width) ||
		(b1.y+b1.height) < b2.y || b1.y > (b2.y+b2.height) || false) {
		return false;
	}
	return true;
}

utility.dom.getBox = function(el) {
	var box = { 
		"x": 0, "y": 0, 
		"width": 0, "height": 0, 
		"scrollTop": 0, "scrollLeft": 0 
	};

	if (el.ownerDocument.getBoxObjectFor) {
		var rect = el.ownerDocument.getBoxObjectFor(el);
		box.x = rect.x - el.parentNode.scrollLeft;
		box.y = rect.y - el.parentNode.scrollTop;
		box.width = rect.width;
		box.height = rect.height;
		box.scrollLeft = el.ownerDocument.body.scrollLeft;
		box.scrollTop = el.ownerDocument.body.scrollTop;
	} else if (el.getBoundingClientRect) {
		var rect = el.getBoundingClientRect();
		box.x = rect.left;
		box.y = rect.top;
		box.width = rect.right - rect.left;
		box.height = rect.bottom - rect.top;
		box.scrollLeft = 0; //el.document.body.scrollLeft;
		box.scrollTop = 0;  //el.document.body.scrollTop;
	} else {
		var tmp = utility.dom.getAbsolutePos(el);
		box.x = tmp.x - el.parentNode.scrollLeft;
		box.y = tmp.y - el.parentNode.scrollTop;
		box.width = utility.dom.getStyleProperty(el, 'width');
		box.height = utility.dom.getStyleProperty(el, 'height');
		box.scrollLeft = el.ownerDocument.body.scrollLeft;
		box.scrollTop = el.ownerDocument.body.scrollTop;
	}
	return box;
}

// from quirksmode, fixed to properly differentiate between IE versions
utility.dom.getPageInnerSize = function() {
	var x, y;
	if (typeof self.innerHeight != "undefined") {
		x = self.innerWidth;
		y = self.innerHeight;
	} else if (typeof document.compatMode != 'undefined' && document.compatMode == 'CSS1Compat') {
		x = document.documentElement.clientWidth;
		y = document.documentElement.clientHeight;
	} else if (document.body) {
		x = document.body.clientWidth;
		y = document.body.clientHeight;
	}
	return {x: x, y: y};
}
// from quirksmode, fixed to properly differentiate between IE versions
utility.dom.getPageScroll = function() {
	var x, y;
	if (typeof self.pageYOffset != 'undefined') {
		x = self.pageXOffset;
		y = self.pageYOffset;
	} else if (typeof document.compatMode != 'undefined' && document.compatMode == 'CSS1Compat') {
		x = document.documentElement.scrollLeft;
		y = document.documentElement.scrollTop;
	}
	else if (document.body) {
		x = document.body.scrollLeft;
		y = document.body.scrollTop;
	}
	return {x: x, y: y};
}

utility.dom.createElement = function(type, attribs, wnd) {
	if (typeof is == 'undefined') {
		is = new BrowserCheck();
	}
	if (typeof wnd != 'undefined') {
		var elem = wnd.document.createElement( type );
	} else {
		var elem = document.createElement( type );
	}
	if ( typeof attribs != 'undefined' ) {
		for (var i in attribs) {
			switch ( true ) {
				case ( i == 'text' )  : 
					elem.appendChild( document.createTextNode( attribs[i] ) ); 
					break;
				case ( i == 'class' ) : 
					elem.className = attribs[i]; 
					break;
				case ( i == 'id' ) : 
					elem.id = attribs[i]; 
					break;
				case ( i == 'type' ) : 
					if (type.toLowerCase()=="input" && is.ie && is.mac) {
						//IE MAC cant set the type
						var tspn = document.createElement("SPAN");
						document.body.appendChild(tspn);
						tspn.style.display= "none";
						tspn.innerHTML = elem.outerHTML.replace(/<input/i, "<input type=\""+attribs[i]+"\"");
						elem = tspn.firstChild;
						document.body.removeChild(tspn);
					} else if (type.toLowerCase()=="input" && is.mac && is.safari) {
						elem.setAttribute('type', attribs[i]);
					} else {
						elem.type = attribs[i]; 
					}
					break;
				case ( i == 'style' ) : 
					elem.style.cssText = attribs[i]; 
					break;
				default : 
					try{
						elem.setAttribute(i, attribs[i] );
						elem[i] = attribs[i];
					}catch(e) {}
			}
		}
	}
	if (attribs['value']) {
		elem.value = attribs['value'];
	}
	return elem;	
};


utility.dom.getImports = function(s) {
	//var ss = document.styleSheets;
	try {
		if (is.ie) {
			return s.imports;
		} else {
			var toret = [];
			for (var i = 0; i < s.cssRules.length; i++) {
				if (is.safari) {
					if (typeof s.cssRules[i].href != 'undefined') {
						Array_push(toret, s.cssRules[i].styleSheet);
					}
				} else {
					if (s.cssRules[i].toString().match('CSSImportRule')) {
						Array_push(toret, s.cssRules[i].styleSheet);
					}
				}
			}
			return toret;
		}
	} catch(e) { return []; }
}

utility.dom.getRuleBySelector = function(s, rx) {
	try {
		var koll = [];
		if (is.ie) {
			koll = s.rules;
		} else {
			koll = s.cssRules;
		}
		var toret = [];
		for (var i = 0; i < koll.length; i++) {
			var rule = koll[i];
			if (rule.selectorText.toString().match(rx)) {
				Array_push(toret, rule);
			}
		}
		return toret;
	} catch(e) { return []; }
}

Object_weave_safe(utility, {date: {}});

$UNI_DATETIME_MASK_SEPARATORS = ['-', '/', '[', ']', '(', ')', '*', '+', '.', '\s', ':'];
$UNI_DATETIME_MASK_REGEXP = '[';
for(var i=0;i<$UNI_DATETIME_MASK_SEPARATORS.length; i++) {
	$UNI_DATETIME_MASK_REGEXP += "\\"+$UNI_DATETIME_MASK_SEPARATORS[i]+'|';
}
$UNI_DATETIME_MASK_REGEXP += ']';
$UNI_DATETIME_MASK_REGEXP = new RegExp($UNI_DATETIME_MASK_REGEXP,"g");

utility.date.date2regexp = function(txt) {
	txt = txt.replace(/[\/\-\.]/g, 'DATESEPARATOR');
	txt = txt.replace(/([-\/\[\]\(\)\*\+\.\:])/g, '\\$1');
	txt = txt.replace(/DATESEPARATOR/g, '[\\/\\-\\.]');
	txt = txt.replace(/(\\s)/g, '\s');
	txt = txt.replace(/yyyy/gi, '([0-9]{1,4})');
	txt = txt.replace(/yy/gi, '([0-9]{1,4})');
	txt = txt.replace(/y/gi, '([0-9]{1,4})');

	txt = txt.replace(/mm/g, '([0-9]{1,2})');
	txt = txt.replace(/m/g, '([0-9]{1,2})');

	txt = txt.replace(/dd/g, '([0-9]{1,2})');
	txt = txt.replace(/d/g, '([0-9]{1,2})');

	txt = txt.replace(/HH/g, '([0-9]{1,2})*');
	txt = txt.replace(/H/g, '([0-9]{1,2})*');

	txt = txt.replace(/hh/g, '([0-9]{1,2})*');
	txt = txt.replace(/h/g, '([0-9]{1,2})*');

	txt = txt.replace(/ii/g, '([0-9]{1,2})*');
	txt = txt.replace(/i/g, '([0-9]{1,2})*');

	txt = txt.replace(/ss/g, '([0-9]{1,2})*');
	txt = txt.replace(/s/g, '([0-9]{1,2})*');

	txt = txt.replace(/tt/g, '(AM|PM|am|pm|A|P|a|p)*');
	txt = txt.replace(/t/g, '(AM|PM|am|pm|A|P|a|p)*');

	txt = txt.replace(/ /g, ' *');
	txt = txt.replace(/:/g, ':*');

	var re = new RegExp('^' + txt + '$');
	return re;
}

utility.date.parse_date = function(arr, dateMask) {
	var vYear = vMonth = vDay = null;
	var vHour = vHour12h = vHour24H = vMinutes = vSeconds = vTimeMarker1C = vTimeMarker2C = null;

	var groups = dateMask.split($UNI_DATETIME_MASK_REGEXP);
	var groupIdx = 0;

	var vTimeMarkerUpdate = 0;
	
	for (var i = 0; i< groups.length; i++) {
		var currentGroupMask = groups[i];
		groupIdx++;
		var groupValue = arr[groupIdx];

		if (Array_indexOf('HH,H,ii,i,ss,s'.split(','), currentGroupMask) >= 0) {
			if (groupValue == '' || typeof groupValue == 'undefined') {
				groupValue = '0';
			}
		}
		if (Array_indexOf('hh,h'.split(','), currentGroupMask) >= 0) {
			var tmpValue = parseInt(groupValue, 10);
			if (groupValue == '' || typeof groupValue == 'undefined') {
				groupValue = '12';
			} else if (tmpValue > 12 && tmpValue < 24) {
				var index = (Array_indexOf(groups, 't') >= 0 ? Array_indexOf(groups, 't')+1 : Array_indexOf(groups, 'tt')+1);
				if (arr[index] == '') {
					groupValue = tmpValue - 12;
					vTimeMarkerUpdate = 1;
				}
			}
		}
		if (Array_indexOf('tt,t'.split(','), currentGroupMask) >= 0) {
			if (groupValue == '') {
				groupValue = [['A', 'AM'], ['P', 'PM']][vTimeMarkerUpdate][currentGroupMask.length - 1];
			}
		}

		switch(currentGroupMask) {
		case 'yyyy':
		case 'YYYY':
			vYear = parseInt(groupValue, 10);
			break;
		case 'yy': 
		case 'YY': 
		case 'y':
			vYear = parseInt(groupValue, 10);
			if (vYear < 1000) {
				if (vYear < 10) {
					vYear = 2000 + vYear;
				} else {
					if (vYear < 70) {
						vYear = 2000 + vYear;
					} else {
						vYear = 1900 + vYear;
					}
				}
			}
			break;
		case 'mm':
		case 'm':
			vMonth = parseInt(groupValue, 10);
			//vMonth;
			break;
		case 'dd': 
		case 'd':
			vDay = parseInt(groupValue, 10);
			break;
		case 'HH': 
		case 'H':
			vHour24H = parseInt(groupValue, 10);
			break;
		case 'hh': 
		case 'h':
			vHour12h = parseInt(groupValue, 10);
			break;
		case 'ii':
		case 'i':
			vMinutes = parseInt(groupValue, 10);
			break;
		case 'ss':
		case 's':
			vSeconds = parseInt(groupValue, 10);
			break;
		case 't':
			vTimeMarker1C = groupValue;
			break;
		case 'tt':
			vTimeMarker2C = groupValue;
			break;
		}
	}


	vYear = vYear == null?1900:vYear;
	vMonth = vMonth == null?0:vMonth;
	vDay = vDay == null?1:vDay;

	vMinutes = vMinutes == null?0:vMinutes;
	vSeconds = vSeconds == null?0:vSeconds;
	var vHourOffset = 0;

	if (vHour12h != null) {
		if (vHour12h >= 1 && vHour12h <= 12) {
			vHour = vHour12h;
			if ((vTimeMarker1C || vTimeMarker2C || "").charAt(0)=="P") {
				if (vHour12h < 12) {
					vHour = vHour12h + 12;
				}
			} else {
				if (vHour12h == 12) {
					vHour = 0;
				}
			}
			//must add 12 to hour if time is PM
			//also, must add 12 if vHour12h in 12h format is greater than 11, which is invalid
			//vHourOffset = ( (vTimeMarker1C || vTimeMarker2C || "").charAt(0)=="P" || vHour12h>11)?12:0;
			//vHour = vHour12h + vHourOffset;
		} else {
			vHour = -1000;
		}
	} else if(vHour24H != null) {
		vHour = vHour24H;
	} else {
		vHour = 0;
	}

	var o = {
		'year': vYear, 
		'month': vMonth, 
		'day': vDay,
		'hour': vHour, 
		'minutes': vMinutes, 
		'seconds': vSeconds
	};

	if (dateMask.indexOf('y') < 0
		&& dateMask.indexOf('m') < 0 
		&& dateMask.indexOf('d') < 0 ) {
		o['year'] = '1900';
		o['month'] = '1';
		o['day'] = 1;
	}
	return o;
}

Object_weave_safe(utility, {window: {}});

utility.window.openWindow = function(target, url, width, height) {
	var wndHandler;
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	var features = ",left=" + left + ",top=" + top;
	var winargs = "width=" + width + ",height=" + height + ",resizable=No,scrollbars=No,status=Yes,modal=yes,dependent=yes";
	var dialogargs = "scrollbars=no,center=yes,dialogHeight=" + height + "px,dialogWidth=" + width
				 + "px,help=no,status=yes,resizable=no";

	if (window.showModalDialog && 0) {
		wndHandler = window.showModelessDialog(url, window, dialogargs + features);
	} else {
		wndHandler = window.open(url, target, winargs + features);
		if (wndHandler) {
			var ctrlModalBlocker = document.getElementById('modalBlocker');
			if (!ctrlModalBlocker) {
				var ctrlModalBlocker = utility.dom.createElement("div", {
					'id'      : 'modalBlocker',
					'style'   : 'display: block',
					'onclick' : utility.window.focusmodal
				});
				var pos = utility.dom.getPageInnerSize();
				ctrlModalBlocker = document.body.appendChild(ctrlModalBlocker);
				ctrlModalBlocker.style.width = pos.x + 'px';
				ctrlModalBlocker.style.height = pos.y + 'px';

				utility.dom.attachEvent(window, 'focus', utility.window.focusmodal);
			} else {
				ctrlModalBlocker.style.display = 'block';
			}
			utility.window.reference = wndHandler;
			wndHandler.focus();
		}
	}

	if (!wndHandler) {
		alert('Cannot open dialog. Please allow site popups.');
	}

	return wndHandler;
}

utility.window.focusmodal = function() {
	if (utility.window.reference && !utility.window.reference.closed) {
		utility.window.reference.focus();
		return;
	}
	utility.window.hideModalBlocker();
}

utility.window.hideModalBlocker = function () {
	var ctrlModalBlocker = document.getElementById('modalBlocker');
	if (ctrlModalBlocker) {
		ctrlModalBlocker.style.display = 'none';
	}
}

utility.window.close = function() {
	window.close();
}

utility.window.blockInterface = function(clickCallBack) {
	var ctrlInterfaceBlocker = utility.dom.createElement('div', {});
	var id = 'interfaceBlocker';
	if (clickCallBack) {
		id = 'clickableInterfaceBlocker';
		ctrlInterfaceBlocker.onclick = clickCallBack;
	}
	ctrlInterfaceBlocker.id = id;
	ctrlInterfaceBlocker = document.body.appendChild(ctrlInterfaceBlocker);
	ctrlInterfaceBlocker.oncontextmenu = function (){return false;};
	var pos = utility.dom.getPageInnerSize();
	ctrlInterfaceBlocker.style.width = pos.x + 'px';
	ctrlInterfaceBlocker.style.height = pos.y + 'px';
}

utility.window.unblockInterface = function() {
	var ctrlInterfaceBlocker = document.getElementById('interfaceBlocker');
	if (!ctrlInterfaceBlocker) {
		ctrlInterfaceBlocker = document.getElementById('clickableInterfaceBlocker');
	}
	if (ctrlInterfaceBlocker) {
		document.body.removeChild(ctrlInterfaceBlocker);
	}
}

utility.window.setModal = function() {
	if (!window.dialogArguments) {
		utility.dom.attachEvent2(window, 'unload', utility.window.hideModalBlocker);
		utility.dom.setUnselectable(window.document.body);
	} else {
		window.opener = dialogArguments;
	}
	if (window.opener.topOpener) {
		window.topOpener = window.opener.topOpener;
	} else {
		window.topOpener = window.opener;
	}
}

Object_weave_safe(utility, {cookie: {}});

utility.cookie.set = function(name, value, lifespan, access_path) {
	var cookietext = name + "=" + escape(value);
	if (lifespan != null) {
		var date = new Date();
		date.setTime(date.getTime() + (1000*60*60*24*lifespan));
		cookietext += "; expires=" + date.toGMTString();
	}
	if (access_path != null) {
		cookietext += "; path=" + access_path;
	}
	document.cookie = cookietext;
	return null;
}

utility.cookie.get = function(name) {
	var nameeq = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') {
			c = c.substring(1,c.length);
		}
		if (c.indexOf(nameeq) == 0) {
			return unescape(c.substring(nameeq.length,c.length));
		}
	}
	return null;
}

utility.cookie.del = function(name, path) {
	utility.cookie.set(name, "", -1, path);
}

// simple UID generator
UIDGenerator = function(name) {
	if (typeof(name) == 'undefined') {
		name = 'iaktuid_' + Math.random().toString().substring(2, 6) + '_';
	}
	this.name = name;
	this.counter = 1;
}
UIDGenerator.prototype.generate = function() {
	return (this.name + this.counter++ + '_');
}

QueryString = function(str) {
	if (typeof str == 'undefined') {
		var str = window.location.search.toString();
	}
	this.keys = new Array();
	this.values = new Array();
	var query = str;
	if (str.indexOf('?') == 0) {
		query = str.substring(1);
	}
	query = query.replace(/&amp;/g, '&');
	var pairs = query.split("&");

	for (var i = 0; i < pairs.length; i++) {
		var pos = pairs[i].indexOf('=');

		if (pos >= 0) {
			var argname = pairs[i].substring(0, pos);
			var value = pairs[i].substring(pos + 1);
			this.keys[this.keys.length] = argname;
			this.values[this.values.length] = value;
		}
	}
}

QueryString.prototype.find = function(key) {
	var value = null;
	for (var i = 0; i < this.keys.length; i++) {
		if (this.keys[i] == key) {
			value = this.values[i];
			break;
		}
	}
	return value;
}

KT_Tooltips = {
	cname: 'kt_add_tooltips', 
	show: function (id, x, y) {
		var div = document.getElementById(id);
		div.style.left = x + 'px';
		div.style.top = y + 'px';
		div.style.display = 'block';
	}, 
	hide: function (id) {
		var div = document.getElementById(id);
		div.style.display = 'none';
	}, 
	clear_timeout: function(id, mode) {
		var to = id + mode + "timeout";
		if (typeof window[to] != 'undefined') {
			clearTimeout(window[to]);
		}
	}, 
	clear_showtimeout: function(id) {
		KT_Tooltips.clear_timeout(id, 'show');
	}, 
	clear_hidetimeout: function(id) {
		KT_Tooltips.clear_timeout(id, 'hide');
	}, 
	set_timeout: function(id, mode, time) {
		var params_str = '', params_arr = [];
		if (arguments.length > 3) {
			for (var i = 3; i < arguments.length; i++) {
				Array_push(params_arr, arguments[i]);
			}
		}
		params_str = params_arr.join(', ');
		if (params_str != '') {
			params_str = ', ' + params_str;
		}
		var str = "KT_Tooltips." + mode + "('" + id + "'"+ params_str+")";
		var to = id + mode + "timeout";
		window[to] = setTimeout(str, time);
	}, 
	set_showtimeout: function(id, vars) {
		KT_Tooltips.set_timeout(id, "show", 1000, vars.x, vars.y);
	}, 
	set_hidetimeout: function(id) {
		KT_Tooltips.set_timeout(id, "hide", 250);
	}, 
	attach: function () {
		var worked = [];
		var gen = new UIDGenerator();
		if (is.ie || is.safari) {
			return;
		}
		Array_each(utility.dom.getElementsByClassName(document.body, KT_Tooltips.cname), function(el) {
			Array_each(el.getElementsByTagName('a'), function(link) {
				var title = link.title;
				if (/[\r\n]/.test(title)) {
					if (Array_indexOf(worked, link) < 0) {
						var divid = gen.generate("tooltip");
						var div = utility.dom.createElement("div", {
							'class': 'tooltip_div', 
							'id': divid
						});
						div.innerHTML = link.getAttribute("title").toString().replace(/\r\n/g, "<br />").replace(/[\r|\n]/g, "<br />");
						div = document.body.appendChild(div);
						link.removeAttribute("title");
						link.setAttribute("divid", divid);
						utility.dom.attachEvent(link, 'mouseover', function(e) {
							var id = link.getAttribute("divid");
							var pos = utility.dom.getBox(link);
							if (is.safari) {
								pos.width = parseInt(link.offsetWidth, 10);
								pos.height = parseInt(link.offsetHeight, 10);
							}
							var vars = utility.dom.setEventVars(e);
							KT_Tooltips.clear_hidetimeout(id);
							var obj = {x: pos.x + Math.round(pos.width / 2), y: pos.y + pos.height + 10};
							KT_Tooltips.set_showtimeout(id, obj);
							utility.dom.stopEvent(e);
						});
						utility.dom.attachEvent(link, 'mouseout', function(e) {
							var id = link.getAttribute("divid");
							KT_Tooltips.clear_showtimeout(id);
							KT_Tooltips.set_hidetimeout(id);
							utility.dom.stopEvent(e);
						});
						Array_push(worked, link);
					}
				}
			});
		}) 
	}
};
utility.dom.attachEvent(window, 'load', KT_Tooltips.attach);

/*
 * class XmlHttp
*/
//MsXML on Mozilla
function getDomDocumentPrefix() {
	if (getDomDocumentPrefix.prefix) return getDomDocumentPrefix.prefix;
	var prefixes = ["MSXML2", "Microsoft", "MSXML", "MSXML3"];
	var o;

	for (var i = 0; i < prefixes.length; i++) {
		try {
			o = new ActiveXObject(prefixes[i] + ".DomDocument");
			return getDomDocumentPrefix.prefix = prefixes[i];
		} catch (ex) { }
	}
	throw new Error("Could not find an installed XML parser");
}
function getXmlHttpPrefix() {
	if (getXmlHttpPrefix.prefix) return getXmlHttpPrefix.prefix;

	var prefixes = ["MSXML2", "Microsoft", "MSXML", "MSXML3"];
	var o;

	for (var i = 0; i < prefixes.length; i++) {
		try {
			// try to create the objects
			o = new ActiveXObject(prefixes[i] + ".XmlHttp");
			return getXmlHttpPrefix.prefix = prefixes[i];
		} catch (ex) { }
	}

	throw new Error("Could not find an installed XML parser");
}

// XmlHttp factory
function XmlHttp() { }
XmlHttp.create = function() {
	try {
		if (window.XMLHttpRequest) {
			var req = new XMLHttpRequest();
			if (req.readyState == null) {
				req.readyState = 1;
				req.addEventListener("load", 
					function() {
						req.readyState = 4;
						if (typeof req.onreadystatechange == "function") 
							req.onreadystatechange();
					}, false);
			}
			return req;
		}
		if (window.ActiveXObject) {
			var ax = new ActiveXObject(getXmlHttpPrefix() + ".XmlHttp");
			return ax;
		}
	} catch (ex) { }

	// fell through
	throw new Error("Your browser does not support XmlHttp objects");
}
XmlHttp.post = function(rpc, url, postStr) {
	try {
		rpc.open("POST", url, false);
		rpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		rpc.send(postStr);
	} catch(e) {
		return false;
	}
	return rpc;
}
XmlHttp.get = function(rpc, url, getStr) {
	try {
		rpc.open("GET", getStr, false);
		rpc.send(null);
	} catch(e) {
		return false;
	}
	return rpc;
}

// XmlDocument factory
function XmlDocument() {}

XmlDocument.create = function () {
	try {
		// DOM2
		if (document.implementation && document.implementation.createDocument) {
			var doc = document.implementation.createDocument("", "", null);
			
			// some versions of Moz do not support the readyState property
			// and the onreadystate event so we patch it!
			if (doc.readyState == null) {
				doc.readyState = 1;
				doc.addEventListener("load", function () {
					doc.readyState = 4;
					if (typeof doc.onreadystatechange == "function")
						doc.onreadystatechange();
				}, false);
			}
			
			return doc;
		}
		if (window.ActiveXObject)
			return new ActiveXObject(getDomDocumentPrefix() + ".DomDocument");
	}
	catch (ex) {}
	throw new Error("Your browser does not support XmlDocument objects");
};

// Create the loadXML method and xml getter for Mozilla
if (window.DOMParser &&
	window.XMLSerializer &&
	window.Node && Node.prototype && Node.prototype.__defineGetter__) {

	// XMLDocument did not extend the Document interface in some versions
	// of Mozilla. Extend both!
	//XMLDocument.prototype.loadXML = 
	Document.prototype.loadXML = function (s) {
		
		// parse the string to a new doc	
		var doc2 = (new DOMParser()).parseFromString(s, "text/xml");
		
		// remove all initial children
		while (this.hasChildNodes())
			this.removeChild(this.lastChild);
			
		// insert and import nodes
		var ret = false;
		for (var i = 0; i < doc2.childNodes.length; i++) {
			this.appendChild(this.importNode(doc2.childNodes[i], true));
			ret = true;
		}
		return ret;
	};
	
	
	/*
	 * xml getter
	 *
	 * This serializes the DOM tree to an XML String
	 *
	 * Usage: var sXml = oNode.xml
	 *
	 */
	// XMLDocument did not extend the Document interface in some versions
	// of Mozilla. Extend both!
	/*
	XMLDocument.prototype.__defineGetter__("xml", function () {
		return (new XMLSerializer()).serializeToString(this);
	});
	*/
/*@cc_on @*/
/*@if (@_jscript_version >= 3)
	//hide the next block of code from the IE compiler ;)
@else @*/
	var documentProto = Document.prototype;
	var documentGrandProto = documentProto.__proto__ = {
		__proto__: documentProto.__proto__
	};
	
	if (documentGrandProto) {
		documentGrandProto.__defineGetter__('xml',
			function () { return (new XMLSerializer()).serializeToString(this); }
		);
	}

	var elementProto = Element.prototype;
	var elementGrandProto = elementProto.__proto__ = {
		__proto__: elementProto.__proto__
	};
	if (elementGrandProto) {
		elementGrandProto.__defineGetter__('text',
			function () { return (new XMLSerializer()).serializeToString(this).replace(/<[^>]*>/g, ''); }
		);
		elementGrandProto.__defineGetter__('innerText',
			function () { return (new XMLSerializer()).serializeToString(this).replace(/<[^>]*>/g, ''); }
		);
		elementGrandProto.__defineSetter__('innerText',
			function (new_value) { 
				var tn = this.ownerDocument.createTextNode(new_value);
				this.innerHTML = "";
				this.appendChild(tn);
			}
		);
	}

/*@end @*/
}

function evaluateXPath(aNode, aExpr) {
	var found = [];
	if (is.mozilla) {
		if (typeof evaluateXPath.xpe == "undefined") {
			evaluateXPath.xpe = new XPathEvaluator();
		}
		//var nsResolver = xpe.createNSResolver(aNode.ownerDocument == null ? aNode.documentElement : aNode.ownerDocument.documentElement);
		//var result = xpe.evaluate(aExpr, aNode, nsResolver, XPathResult.ANY_TYPE, null);
		var result = evaluateXPath.xpe.evaluate(aExpr, aNode, null, XPathResult.ANY_TYPE, null);
		while (res = result.iterateNext()) {
			found.push(res);
		}
	} else if (is.ie) {
		var result = aNode.selectNodes(aExpr);
		for(var i=0; i<result.length; i++) {
			found.push(result[i]);
		}
	}
	if (found.length == 0) {
		found = false;
	}
	return found;
}
function BrowserCheck() {
	var b = navigator.appName.toString();
	var up = navigator.platform.toString();
	var ua = navigator.userAgent.toString();

	this.mozilla = this.ie = this.opera = r = false;
	var re_opera = /Opera.([0-9\.]*)/i;
	var re_msie = /MSIE.([0-9\.]*)/i;
	var re_gecko = /gecko/i;
	var re_safari = /safari\/([\d\.]*)/i;
	
	if (ua.match(re_opera)) {
		r = ua.match(re_opera);
		this.opera = true;
		this.version = parseFloat(r[1]);
	} else if (ua.match(re_msie)) {
		r = ua.match(re_msie);
		this.ie = true;
		this.version = parseFloat(r[1]);
	} else if (ua.match(re_safari)) {
		this.mozilla = true;
		this.safari = true;
		this.version = 1.4;
	} else if (ua.match(re_gecko)) {
		var re_gecko_version = /rv:\s*([0-9\.]+)/i;
		r = ua.match(re_gecko_version);
		this.mozilla = true;
		this.version = parseFloat(r[1]);
	}
	this.windows = this.mac = this.linux = false;

	this.Platform = ua.match(/windows/i) ? "windows" :
					(ua.match(/linux/i) ? "linux" :
					(ua.match(/mac/i) ? "mac" :
					ua.match(/unix/i)? "unix" : "unknown"));
	this[this.Platform] = true;
	this.v = this.version;
	this.valid = this.ie && this.v >= 6 || this.mozilla && this.v >= 1.4;
	if (this.safari && this.mac && this.mozilla) {
		this.mozilla = false;
	}
}

function sortFormHandlers(arr) {
	for(var i=0; i<arr.length; i++) {
		var fh1 = arr[i];
		for(var j=i+1;j<arr.length;j++) {
			var fh2 = arr[j];
			if (fh2[0]<fh1[0]) {
				var tmp = fh1;
				arr[i] = fh2;
				arr[j] = tmp;
			}
		}
	}
}

function GLOBAL_registerFormSubmitEventHandler(function_name, priority) {
	var frms = document.getElementsByTagName('form');
	for (var i = 0; i < frms.length; i++) {
		var frm = frms[i];
		if (typeof frm.onsubmit != 'undefined' && frm.onsubmit != null) {
			var form_handlers = frm.form_handlers;
			if (form_handlers) {
				form_handlers[form_handlers.length] = [priority, function_name];
				sortFormHandlers(form_handlers);
			} else {
				var tmp = frm.onsubmit.toString();
				var str = tmp.substring(tmp.indexOf('{')+1, tmp.lastIndexOf('}'));
				frm.onsubmit = new Function('e', 'if (!KT_formSubmittalHandler(e)) return false; ' + str);
				form_handlers = [];
				form_handlers[form_handlers.length] = [priority, function_name];
			}
			frm.form_handlers = form_handlers;
		} else {
			frm.onsubmit = new Function('e', 'return KT_formSubmittalHandler(e);');
			var form_handlers = [];
			form_handlers[form_handlers.length] = [priority, function_name];
			frm.form_handlers = form_handlers;
		}
	}
}

var global_form_submit_lock = false;

function KT_formSubmittalHandler(e) {
	var o = utility.dom.setEventVars(e);
	if (global_form_submit_lock) {
		utility.dom.stopEvent(e);
		return false;
	}
	var frm = o.targ;
	if (!frm.tagName) {
		//bug: ie 5.2 submit action
		return true;
	}
	if (frm.tagName.toLowerCase() != "form") {
		frm = frm.form;
	}
	if (typeof(UNI_disableButtons) != 'undefined') {
		UNI_disableButtons(frm, /.*/, true);
	}
	var ret = true;
	var form_handlers = frm.form_handlers;
	if (form_handlers) {
		for(var i=0; i<form_handlers.length; i++) {
			var fun = form_handlers[i];
			eval("ret = " + fun[1] + "(e);");
			if (!ret) {
				break;
			}
		}
	}
	//bug: ie 5.2 submit action
	if (is.ie && is.mac) {
		UNI_disableButtons(frm, /.*/, false);
	}
	if (!ret) {
		//the form submit lock does not enables the buttons
		if (!global_form_submit_lock && typeof(UNI_disableButtons) != 'undefined') {
			UNI_disableButtons(frm, /.*/, false);
		}
		utility.dom.stopEvent(e);
	}
	return ret;
}


utility.dom.attachEvent(window, 'unload', EventCache.flush);
