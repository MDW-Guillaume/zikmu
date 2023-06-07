function generateRandomPassword() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let password = '';

    for (let i = 0; i < 10; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        password += characters.charAt(randomIndex);
    }

    return password;
}

$(document).on('click', '.generate-password', function () {
    var input = $($(this).attr('toggle'));
    let password = generateRandomPassword();
    console.log(password);
    $(input).val(password);
});

