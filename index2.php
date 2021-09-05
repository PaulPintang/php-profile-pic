<?php
  $db = mysqli_connect("localhost", "root", "", "profile-pic");
  $results = mysqli_query($db, "SELECT * FROM users");
  $users = mysqli_fetch_all($results, MYSQLI_ASSOC);
?>
 <?php include('process2.php'); 
   if(isset($_GET['edit'])){
            $id = $_GET['edit'];
            $update = true;
            $rec = mysqli_query($db, "SELECT * FROM users WHERE id=$id");
            $record = mysqli_fetch_array($rec);
            $info = $record['info'];
            $picture = $record['picture'];
            $id = $record['id'];
   }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>
      <div class="flex items-center justify-center pt-6">
      <div class="h-auto">
          <form action="process2.php" method="POST" enctype="multipart/form-data">
            <div class="cursor flex flex-col items-center">
                <div 
                  class="rounded-full border-4 border-blue-300 overflow-hidden" 
                  style="width: 130px; height: 130px;">
                  <img 
                      src="./images/user.png"
                      onClick="triggerClick()" 
                      id="profileDisplay"
                      style="object-fit: cover; width: 100%; height: 100%"
                      name="picture"
                    >
                </div>
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input 
                  type="file" 
                  name="profileImage" 
                  style="opacity: 0; top: -60px;  position:relative"
                  onChange="displayImage(this)" 
                  id="profileImage" 
                  value="<?php echo $picture; ?>"
                >
                <input type="text" name="info" class="focus:outline-none focus:border-blue-400 border-gray-300 p-2 border rounded" placeholder="Name"
                value="<?php echo $info; ?>"
                >
            </div>
            <div class="flex justify-center p-4">
                 <?php if ($update == false): ?>
                    <button class="bg-green-500 text-white p-2 rounded-md pl-4 pr-3" type="submit" name="save">ADD</button>
                    <?php else: ?>
                    <button class="bg-green-500 text-white p-2 rounded-md pl-4 pr-3" type="submit" name="update">UPDATE</button>
                    <?php endif; ?>
            </div>
          </form>
      </div>
    </div>
    <div class="flex justify-center items-center">
    <div class="h-auto">
      <div>
        <h1 class="text-center text-4xl p-5">PHP CRUD / Profile Pic<br>Concept + TailwindCSS</h1>
      </div>
      <div class="flex flex-col mx-auto" style="max-width: 1000px">
        <!-- <button class="pb-1 pt-1 pl-5 pr-5 bg-blue-500 text-white rounded mb-5" type="submit" name="save" onclick="toggleModal('modal-id')">Add new</button> -->
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Picture
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <?php foreach ($users as $user): ?>
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="rounded-full overflow-hidden" style="width: 50px; height: 50px;">
                            <img src="<?php echo 'images/'.$user['picture']; ?>" alt="" class="object-cover" style=" width: 100%; height: 100%"> 
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <?php echo $user['info']; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-300">
                            <a href="index2.php?edit=<?php echo $user['id']; ?>" class="text-white hover:text-indigo-900">Edit</a>
                          </span>
                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100">
                            <a href="process2.php?del=<?php echo $user['id']; ?>"
                               class="text-red-600 hover:text-indigo-900">Delete</a>
                          </span>
                        </td>
                      </tr>
                  <?php endforeach; ?>

                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
  <script>
    function triggerClick(e) {
      document.querySelector("#profileImage").click();
    }
    function displayImage(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document
            .querySelector("#profileDisplay")
            .setAttribute("src", e.target.result);
        };
        reader.readAsDataURL(e.files[0]);
      }
    }
  </script>
</html>