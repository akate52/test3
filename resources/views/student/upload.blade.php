

<form method="POST" enctype="multipart/form-data" action="/student/upload">
    @csrf
    选择文件：<input type="file" name="test" value="" />
    <button type="submit">文件上传</button>
</form>