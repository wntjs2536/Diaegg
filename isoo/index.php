<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Photo Upload</title>
    <script
            src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</head>
<body>

<div id="frame">
    <img src="/isoo/thumb/phpThumb.php?src=/isoo/images/white.png&w=400&h=850&fltr[]=over|/isoo/images/frame_border.png"
         id="frame_pic"/>
</div>

<form name="frm" id="frm">
    <input type="file" name="photo" id="photo" onchange="go_upload_photo();" accept="image/*"/>
    <input type="button" value="사진 저장" id="download"/>
</form>

<style>
    #frame {
        width: 100%;
    }

    #frame_pic {
        width: 100%;
    }

    #frm input {
        padding: 3px;
        height: 35px;
        line-height: 35px;
        font-size: 14px;
    }

    input[type="file"]::-webkit-file-upload-button {
        height: 35px;
    }

</style>

<script>
    let file_name;

    function go_upload_photo() {
        let formData = new FormData();
        let file = $("input[type=file]")[0].files[0];

        formData.append("photo", file)
        $.ajax({
            type: "POST",
            url: "file_upload.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                let data = response.split("@@@");

                if (data[0] === "SUCCESS") {
                    //alert('성공적으로 업로드 하였습니다.');
                    file_name = data[1];

                    console.log(file_name);
                    //$("#real_pic").attr("src", file_name);

                    $("#frame_pic").attr("src", "/isoo/thumb/phpThumb.php?src=" + file_name + "&w=400&ar=x&h=850&fltr[]=over|/isoo/images/frame_border.png");
                } else {
                    alert('오류가 발생했습니다.');
                }
            },
            err: function (err) {
                alert(err.status);
            }
        });
    }

    function printDiv(div) {
        div = div[0];
        html2canvas(div).then(function (canvas) {
            let myImage = canvas.toDataURL();
            console.log(myImage);
            return;
            downloadURI(myImage, "my_memory.png");
        });
    }

    function downloadURI(uri, name) {
        let link = document.createElement("a");
        link.download = name;
        link.href = uri;
        document.body.appendChild(link);
        link.click();
    }

    $(function () {
        $("#download").click(function () {
            saveDivAsImage("frame");
        })
    })

    function saveDivAsImage(id) {
        html2canvas(document.getElementById(id)).then(canvas => {
            let myImage = canvas.toDataURL();
            downloadURI(myImage, "my_memory.png");
        });
    }

</script>
</body>
</html>
