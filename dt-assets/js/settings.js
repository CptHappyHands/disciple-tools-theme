function switch_preference(preference_key, type=null) {
  let data = {"preference_key": preference_key, type}
  return jQuery.ajax({
    type: "POST",
    data: JSON.stringify(data),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    url: wpApiSettingsPage.root + 'dt/v1/users/switch_preference',
    beforeSend: function (xhr) {
      xhr.setRequestHeader('X-WP-Nonce', wpApiSettingsPage.nonce);
    },
  })
}

function change_password() {
    let translation = wpApiSettingsPage.translations
    // test matching passwords
    let p1 = jQuery('#password1')
    let p2 = jQuery('#password2')
    let message = jQuery('#password-message')

    message.empty()

    if ( ! ( p1.val() === p2.val() ) ) {
        message.append(translation.pass_does_not_match)
        return;
    }

    let data = {"password": p1}
    jQuery.ajax({
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: wpApiSettingsPage.root + 'dt/v1/users/change_password',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', wpApiSettingsPage.nonce);
        },
    })
        .done(function (data) {
            console.log( data )
            message.html(translation.changed)

        })
        .fail(function (err) {
            console.log("error")
            console.log(err)
            message.html(translation.not_changed + ' ' + err.responseText)
            jQuery("#errors").append(err.responseText)
        })

}



