<!DOCTYPE html>
<html>
<body>

<form action="./src/upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="radio" id="AIB" name="type" value="AIB" checked />
    <label for="AIB">AIB</label>
    <input type="radio" id="Revolut" name="type" value="Revolut"  />
    <label for="Revolut">Revolut</label>
  <input type="submit" value="Upload " name="submit">
</form>

</body>
</html>

