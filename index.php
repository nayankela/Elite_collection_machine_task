<?php
include('server.php');

//fetch the records to be updated
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
$edit_state = true;
  $rec = mysqli_query($db, "SELECT id,email FROM info WHERE id=$id");
  $record = mysqli_fetch_array($rec);
  $email = $record['email'];
  $id = $record['id'];
}

if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
  {
        $secret = 'your_actual_secret_key';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success)
        {
            $succMsg = 'Your contact request have submitted successfully.';
        }
        else
        {
            $errMsg = 'Robot verification failed, please try again.';
        }
   }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Home</title>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js" async defer> </script>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <title>Registeration Form</title>
  </head>
  <body>
<?php if (isset($_SESSION['msg'])): ?>
  <div class="msg">
    <?php
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
     ?>
  </div>
<?php endif; ?>

    <table>
      <thead>

      <tr>
        <th>Name</th>
          <th>Email</th>
            <th>Phone Number</th>
              <th>Date of birth</th>
              <th colspan="3">Action</th>
      </tr>
    </thead>
    <tbody>
<?php while ($row = mysqli_fetch_array($results)) { ?>
  <tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['dob']; ?></td>
    <td>   <a class="edit_btn" href="index.php?edit=<?php echo $row['id']; ?>">Edit</a>   </td>
    <td>  <a class="del_btn" href="server.php?del=<?php echo $row['id']; ?>">Delete</a>   </td>
  </tr>
      <?php  } ?>
    </tbody>
    </table>

<form class="" action="server.php" method="post">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <div class="input-group">
    <label>Name</label>
    <input type="text" name ="name" value="<?php echo $name; ?>">
  </div>
  <div class="input-group">
    <label>Email</label>
    <input type="email" name ="email" value="<?php echo $email; ?>">
  </div>
  <div class="input-group">
    <label>Phone number</label>
    <input type="text" name ="phone" value="<?php echo $phone; ?>">
  </div>
  <div class="input-group">
    <label>Date of birth</label>
  <input type="date" name="dob"  value="<?php echo $dob; ?>">
  </div>

  <div class="input-group">
    <div class="g-recaptcha" data-sitekey="6Lcqa-IZAAAAACkng6GFMM1pZ-rrYiP-7hSPlEYx">
    </div>
   </div>

  <div class="input-group">
    <?php if ($edit_state == false): ?>
      <button type="submit" name="save" class="btn">Save</button>
    <?php else: ?>
      <button type="submit" name="update" class="btn">Update</button>
    <?php endif; ?>
</div>
      </form>
  </body>
</html>
