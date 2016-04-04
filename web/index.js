var Credentials = function (email, password) {
    this.email = email;
    this.password = password;
};

var App = function () {
    var self = this;
    self.email = ko.observable("");
    self.password = ko.observable("");
    self.authenticated = ko.observable(false);
    self.loading = ko.observable(false);
    self.forwardersEnabled = ko.observable(false);
    self.forwarders = ko.observableArray([]);

    self.passwordHash = ko.computed(function () {
        return md5(self.password());
    }, self);

    self.newpass1 = ko.observable("");
    self.newpass2 = ko.observable("");
    self.newforwarder = ko.observable("");
    self.passwordemail = ko.observable("");

    self.ajaxCalls = ko.observable(0);
    self.loading = ko.computed(function () {
        return self.ajaxCalls() > 0;
    }, self);


    self._init = function () {
        var credentials = Cookies.getJSON("credentials");
        if (credentials !== undefined) {
            self.email(credentials.email);
            self.password(credentials.password);
            self._login();
        }
        return self;
    };

    self._passwordForgotten = function () {
        request(
            "api/forgot_password.php",
            {
                email: self.passwordemail()
            },
            function (data) {
                if (data.error === null) {
                    showInfo(Translation.get('forgotpasswordsent'));
                } else {
                    switch (data.error) {
                        case 'address_not_found':
                            showError(Translation.get('forgotpasswordnoaccount'));
                            break;
                        case 'forwarding_not_enabled':
                            showError(Translation.get('forgotpasswordnoforwarding'));
                            break;
                    }
                }
            });
    };

    self._logout = function () {
        Cookies.remove("credentials");
        location.reload();
    };

    self._login = function () {
        request(
            "api/authenticate.php",
            {},
            function (data) {
                if (data.error === null) {
                    self.authenticated(true);
                    Cookies.set("credentials", new Credentials(self.email(), self.password()), {expires: 365});
                    self._fetchForwarders();
                } else {
                    showError(Translation.get('loginfailed'));
                    Cookies.remove("credentials");
                }
            });
    };

    self._fetchForwarders = function () {
        request(
            "api/get_forwarders.php",
            {},
            function (data) {
                if (data.error === null) {
                    self.forwardersEnabled(true);
                    self.forwarders(data.data);
                } else {
                    self.forwarders.removeAll();
                    self.forwardersEnabled(false);
                }
            });
    };

    self._changePassword = function () {
        if (self.newpass1() !== self.newpass2()) {
            showError(Translation.get('passwordsmustmatch'));
            return;
        }

        request(
            "api/change_password.php",
            {
                password: self.newpass1()
            },
            function (data) {
                if (data.error === null) {
                    showInfo(Translation.get('passwordischanged'));
                    self.password(self.newpass1());
                    self.newpass1("");
                    self.newpass2("");
                } else {
                    if (data.error === 'password_too_weak') {
                        showError(Translation.get('weakpassword'));
                    } else {
                        showError(Translation.get('passwordchangefailed'));
                    }
                }
            });
    };

    self._deleteForwarder = function (forwarder) {
        request(
            "api/remove_forwarder.php",
            {
                forward: forwarder
            },
            function (data) {
                self._fetchForwarders();
            });
    };

    self._addForwarder = function () {
        var emailValid = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(self.newforwarder());

        if (!emailValid) {
            showError(Translation.get('emailnotvalid'));
            return;
        }

        request(
            "api/add_forwarder.php",
            {
                forward: self.newforwarder()
            },
            function (data) {
                if (data.error === 'forwarding_address_protected') {
                    showError(Translation.get('emailprotected'));
                }
                self._fetchForwarders();
                self.newforwarder("");
            });
    };

    var showInfo = function (text) {
        showPopup(text, 'success');
    };

    var showError = function (text) {
        showPopup(text, 'error');
    };

    var showPopup = function (text, type) {
        sweetAlert("", text, type);
    };

    var request = function (url, data, responseMethod) {
        self.ajaxCalls(self.ajaxCalls() + 1);
        data.email = self.email();
        data.auth = self.passwordHash();
        $.post(url, data, function (data) {
            data = $.parseJSON(data);
            responseMethod(data);
            self.ajaxCalls(self.ajaxCalls() - 1);
        });
    };
};

ko.applyBindings(new App()._init());
