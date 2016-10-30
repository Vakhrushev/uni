;// Close old files

function addEvent(element, type, callback) {
	if (element.addEventListener) {
		element.addEventListener(type, callback, false);
	} else {
		element.attachEvent('on' + type, callback);
	}
}

function setClass(el, className) {
	var str = el.getAttribute('class');
	var list = str.split(' ');
	if (list.indexOf(className) === -1) {
		el.setAttribute('class', str + ' ' + className);
	}
}

function removeClass(el, className) {
	var str = el.getAttribute('class');
	var list = str.split(' ');
	var indx = list.indexOf(className);
	if (indx !== -1) {
		delete(list[indx]);
		list = list.filter(function (n) {
			return n.length > 0
		});
		el.setAttribute('class', list.join(' '));
	}
}

function setError(el, text) {
	setClass(el.parentNode, 'has-error');
}
function cleanError(el) {
	removeClass(el.parentNode, 'has-error');
}


function htmlToElement(html) {
	var template = document.createElement('template');
	template.innerHTML = html;
	return template.content.firstChild;
}

function isValueEmpty(el) {
	var result = true;
	if (el) {
		if (el.value.length === 0) {
			setError(el);
		} else {
			cleanError(el);
			result = false;
		}
	}
	return result;
}


function trigger(el, eventType) {
	var event; // The custom event that will be created

	if (document.createEvent) {
		event = document.createEvent("HTMLEvents");
		event.initEvent(eventType, true, true);
	} else {
		event = document.createEventObject();
		event.eventType = eventType;
	}

	event.eventName = "dataavailable";

	if (document.createEvent) {
		el.dispatchEvent(event);
	} else {
		el.fireEvent("on" + event.eventType, event);
	}
}


(function () {
	'use strict';

	function Login() {
		this.name = document.getElementById('name');
		this.pass = document.getElementById('pass');
	}

	Login.prototype.check = function () {
		var result = true;
		var nameR = isValueEmpty(this.name);
		var passR = isValueEmpty(this.pass);
		if (nameR || passR) {
			result = false;
		}
		return result;
	};
	Login.prototype.submit = function () {
		reqwest({
			url: '/js/login'
			, type: 'json'
			, method: 'get'
			, data: {name: this.name.value, pass: this.pass.value}
			, success: function (json) {
				if (typeof json.jsUser === 'object' && json.jsUser.id > 0) {
					app.setUser(json.jsUser)
				}
			}
		})
	};


	function SingUp() {
		this.name = document.getElementById('name');
		this.pass = document.getElementById('pass');
	}

	SingUp.prototype.check = function () {
		var result = true;
		var nameR = isValueEmpty(this.name);
		var passR = isValueEmpty(this.pass);
		if (nameR || passR) {
			result = false;
		}
		return result;
	};
	SingUp.prototype.submit = function () {
		reqwest({
			url: '/js/singup'
			, type: 'json'
			, method: 'post'
			, data: {name: this.name.value, pass: this.pass.value}
			, success: function (json) {
				if (typeof json.data.status === 'boolean' && json.data.status) {
					app.setUser(json.jsUser)
				}
			}
		});
	};


	function Page() {
		this.title = document.getElementById('js-page-title');
		this.body = document.getElementById('js-body');
	}

	Page.prototype.setPageTitle = function (text) {
		this.title.innerText = text;
	};
	Page.prototype.setBody = function (dom) {
		this.body.innerHTML = '';
		this.body.appendChild(dom);
	};
	Page.prototype.addToBody = function (dom) {
		this.body.appendChild(dom);
	};
	Page.prototype.login = function () {
		this.setPageTitle('Login');
		reqwest('/templates/login.html', function (tmpl) {
			var doc = htmlToElement(tmpl);
			doc.querySelector('#submit').onclick = function (e) {
				e.preventDefault();
				if (login.check()) {
					login.submit();
				}
				return false;
			};
			this.setBody(doc);
			var login = new Login();
		}.bind(this));
	};
	Page.prototype.singup = function () {
		this.setPageTitle('SingUp');
		reqwest('/templates/singup.html', function (tmpl) {
			var doc = htmlToElement(tmpl);
			doc.querySelector('#submit').onclick = function (e) {
				e.preventDefault();
				if (singup.check()) {
					singup.submit();
				}
				return false;
			};
			this.setBody(doc);
			var singup = new SingUp();
		}.bind(this));
	};
	Page.prototype.contact = function (data) {
		this.setPageTitle(data.title);
		reqwest('/templates/contacts.html', function (tmpl) {
			var doc = htmlToElement(tmpl);
			doc.querySelector('#city').innerText = data.data.city;
			doc.querySelector('#address').innerText = data.data.address;
			doc.querySelector('#phone').innerText = data.data.phone;
			doc.querySelector('#fio').innerText = data.data.fio;
			var em = doc.querySelector('#email');
			em.innerText = data.data.email;
			em.setAttribute('href', 'mailto:' + data.data.email);
			console.log(doc);
			this.setBody(doc);
		}.bind(this));
	};
	Page.prototype.list = function (data) {
		this.setPageTitle(data.title);
		var table = document.createElement('table');
		table.setAttribute('class', 'table table-inverse');
		var trow = document.createElement('tr');
		var tdid = document.createElement('th');
		var tdname = document.createElement('th');
		var tddt = document.createElement('th');
		tdid.innerText = '#';
		tdname.innerText = 'Name';
		tddt.innerText = 'date of creation';
		trow.appendChild(tdid);
		trow.appendChild(tdname);
		trow.appendChild(tddt);
		table.appendChild(trow);

		if (data.data.length) {
			this.setBody(table);
			for (var i in data.data) {
				if (data.data.hasOwnProperty(i)) {
					var row = data.data[i];
					trow = document.createElement('tr');
					tdid = document.createElement('th');
					tdid.innerText = row.id;
					tdname = document.createElement('td');
					tdname.innerText = row.name;
					tddt = document.createElement('td');
					tddt.innerText = row.dt_create;
					trow.appendChild(tdid);
					trow.appendChild(tdname);
					trow.appendChild(tddt);
					table.appendChild(trow)
				}
			}
		}
	};

	var page = new Page();


	function Contrllers() {

	}

	Contrllers.prototype.contact = function () {
		reqwest({
			url: '/js/contact'
			, type: 'json'
			, method: 'get'
			, success: function (resp) {
				page.contact(resp);
			}
		})
	};
	Contrllers.prototype.singup = function () {
		if (typeof user === 'object' && user.id > 0) {
			location.href = '/#list';
			return;
		}
		page.singup();
	};
	Contrllers.prototype.login = function () {
		if (typeof user === 'object' && user.id > 0) {
			location.href = '/#list';
			return;
		}
		page.login();
	};
	Contrllers.prototype.list = function () {
		if (!(typeof user === 'object' && user.id > 0)) {
			location.href = '/#login';
			return;
		}
		reqwest({
			url: '/js/lists'
			, type: 'json'
			, method: 'get'
			, success: function (json) {
				page.list(json);
			}
		});
	};


	function App() {
		this.setUpContrlollers();
		this.setUpNav();
		trigger(window, 'hashchange');
	}


	App.prototype.setUser = function (jsUser, noredirect) {
		user = jsUser;
		if (!noredirect) {
			location.href = '/#list';
		}

		var navUl = document.querySelector('.nav');
		if (navUl) {
			navUl.innerHTML += '<li id="logout"><a href="/logout">LogOut</a></li>';
		}
	};
	App.prototype.removeUser = function () {
		user = false;
		location.href = '/';
	};
	App.prototype.setUpContrlollers = function () {
		this.controllers = new Contrllers();
	};
	App.prototype.setUpNav = function () {
		if (typeof user === 'object' && user.id > 0) {
			this.setUser(user, true);
		}
		addEvent(window, 'hashchange', function () {
			var controller = location.hash.replace('#', '');
			if (location.pathname === '/') {
				if (controller && controller.length && typeof this.controllers[controller] === 'function') {
					this.controllers[controller]();
				} else if (controller === '') {
					this.controllers['login']();
				}
			}

		}.bind(this));
	};

	var app;
	addEvent(window, 'load', function () {
		app = new App();
	});
}());