var Languages = {
    english: {
        login: "Login",
        loginfailed: "Can't log in. Maybe you entered the wrong login data?",
        forwarders: "Forwarding adresses",
        forwardersdisabled: "Mail forwarding is not enabled for your account. Please contact your mail administrator.",
        changepassword: "Change mailbox password",
        delete: "Delete",
        logintext: "Please enter your email account login details.",
        email: "Email address",
        password: "Password",
        newpass1: "New password",
        newpass2: "Repeat new password",
        save: "Save",
        passwordsmustmatch: "The entered passwords are not the same. Please try again..",
        passwordischanged: "Your password has been changed.",
        passwordchangefailed: "Can't change your password. Maybe try again later?",
        emailnotvalid: "The entered email address is not valid!",
        logout: "Logout",
        headline: "Email Account Management for adress ",
        emailprotected: "This address is protected by an Administrator and can not be used.",
        weakpassword: "The selected password is not strong enough.",
        passwordforgotten: "If you have forgotten your password, we can send it to your forwarding addresses, if enabled.",
        sendpassword: "Send Password",
        forgotpasswordsent: "The password has been sent to your forwarding addresses.",
        forgotpasswordnoaccount: "The email address was not found.",
        forgotpasswordnoforwarding: "Sorry, but email forwarding is not enabled for your account. Please contact your mail administrator."

    },
    german: {
        login: "Login",
        loginfailed: "Anmeldung fehlgeschlagen. Sind die Anmeldedaten korrekt?",
        forwarders: "Email Weiterleitungen",
        forwardersdisabled: "Email Weiterleitungen sind für den Account nicht aktiviert. Bitte an den Email Administrator wenden.",
        changepassword: "Account-Passwort ändern",
        delete: "Löschen",
        logintext: "Account Login-Daten eingeben.",
        email: "Email-Adresse",
        password: "Passwort",
        newpass1: "Neues Passwort",
        newpass2: "Passwort wiederholen",
        save: "Speichern",
        passwordsmustmatch: "Die beiden Passwörter sind nicht identisch. Bitte erneut versuchen..",
        passwordischanged: "Das Passwort wurde geändert.",
        passwordchangefailed: "Passwort konnte nicht geändert werden. Bitte später erneut versuchen..",
        emailnotvalid: "Die eingegebene Email-Adresse existiert nicht.",
        logout: "Abmelden",
        headline: "Email Account-Verwaltung von ",
        emailprotected: "Diese Adresse ist von einem Administrator reserviert und kann nicht verwendet werden.",
        weakpassword: "Das eingegebene Passwort entspricht nicht den Anforderungen.",
        passwordforgotten: "Passwort vergessen? Hier kann es an die hinterlegten Weiterleitungs-Adressen gesendet werden.",
        sendpassword: "Passwort anfordern",
        forgotpasswordsent: "Das Passwort wurde an die Weiterleitungs-Adressen gesendet.",
        forgotpasswordnoaccount: "Die Email-Adresse wurde nicht gefunden.",
        forgotpasswordnoforwarding: "Leider sind Weiterleitungen für diesen Account nicht aktiviert. Bitte an den Mail-Administrator wenden."
    },
    greek: {
        login: "Σύνδεση",
        loginfailed: "Αδυναμία σύνδεσης. Μήπως έχετε δώσει λάθος στοιχεία;",
        forwarders: "Διευθύνσεις Προώθησης",
        forwardersdisabled: "Η προώθηση των email δεν είναι ενεργοποιημένη. Επικοινωνήστε με τον διαχειριστή.",
        changepassword: "Αλλαγή κωδικού",
        delete: "Διαγραφή",
        logintext: "Πληκτρολογήστε τα στοιχεία σύνδεσης του email σας",
        email: "Διεύθυνση Email",
        password: "Κωδικός",
        newpass1: "Νέος Κωδικός",
        newpass2: "Επανάληψη Νέου Κωδικού",
        save: "Αποθήκευση",
        passwordsmustmatch: "Οι κωδικοί δεν είναι ίδιοι. Προσπαθήστε ξανά...",
        passwordischanged: "Ο κωδικός σας έχει τροποποιηθεί.",
        passwordchangefailed: "Αδυναμία αλλαγής του κωδικού. Θέλετε να δοκιμάστε αργότερα;",
        emailnotvalid: "Δεν είναι σωστός ο κωδικός που πληκτρολογήσατε!",
        logout: "Αποσύνδεση",
        headline: "Διαχείριση Email για την διεύθυνση ",
        emailprotected: "Αυτή η διεύθυνση προστατεύεται από ένα διαχειριστή και δεν μπορούν να χρησιμοποιηθούν.",
        weakpassword: "Το επιλεγμένο κωδικός πρόσβασης δεν είναι αρκετά ισχυρή.",
        passwordforgotten: "Εάν έχετε ξεχάσει τον κωδικό σας, μπορούμε να στείλουμε στις διευθύνσεις προώθησης σας, αν ενεργοποιηθεί.",
        sendpassword: "στείλουμε τον κωδικό",
        forgotpasswordsent: "Ο κωδικός πρόσβασης έχει σταλεί στη διεύθυνση αποστολής σας.",
        forgotpasswordnoaccount: "Η διεύθυνση email δεν βρέθηκε.",
        forgotpasswordnoforwarding: "Συγγνώμη, αλλά προώθηση email δεν είναι ενεργοποιημένη για το λογαριασμό σας. Επικοινωνήστε με το διαχειριστή Email σας."
    }
};

var Translation = {
    language: null,
    get: function (key) {
        var value = Languages[this.language][key];
        if (value === undefined) {
            console.error("Undefined Translation for '" + key + "'");
            value = Languages['english'][key];
        }
        return value;
    }
};