function upload_image(image, token) {
    
    let profil_image = $('#' + image)[0].files[0],
    max_size = 500000,
    valid_ext = ['.jpg', '.jpeg', '.png'],
    file_ext = profil_image['name'].toLowerCase().substr(profil_image['name'].indexOf("."));
    let file_size = profil_image['size'];

    if($.inArray(file_ext, valid_ext) === -1) {
        alert("Le fichier n'est pas une image");
        return false;
    }

    if(max_size < file_size) {
        alert("L'image est trop volumineuse");
        return false;
    }

    let formData = new FormData();
    formData.append(image, profil_image);
    formData.append('token', token);

    return formData;
}