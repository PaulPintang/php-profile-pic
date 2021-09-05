<?php
  $db = mysqli_connect("localhost", "root", "", "profile-pic");
  $results = mysqli_query($db, "SELECT * FROM users");
  $users = mysqli_fetch_all($results, MYSQLI_ASSOC);
?>
 <?php include('process.php'); 
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>PHP Profile Picture</title>
  </head>
  <body>
    <div class="flex justify-center items-center h-screen">
    <div class="h-auto">
      <div>
        <h1 class="text-center text-4xl p-5">PHP CRUD / Profile Pic<br>Concept + TailwindCSS</h1>
      </div>
      <div class="flex flex-col mx-auto" style="max-width: 1000px">
        <button class="pb-1 pt-1 pl-5 pr-5 bg-blue-500 text-white rounded mb-5" type="submit" name="save" onclick="toggleModal('modal-id')">Add new</button>
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
                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-300" >
                            <a href="index.php?edit=<?php echo $user['id']; ?>" class="text-white hover:text-indigo-900" onclick="toggleModal('modal-id')">Edit</a>
                          </span>
                          <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100">
                            <a href="process.php?del=<?php echo $user['id']; ?>"
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

    <!-- This example requires Tailwind CSS v2.0+ -->
          <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
              <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <div class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                  <h3 class="font-semibold" style="font-size: 20px">
                    Add profile
                  </h3>
                  <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id')">
                    <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                      ×
                    </span>
                  </button>
                </div>
                <!--body-->
                <div class="relative p-6 flex-auto">
                <form action="process.php" method="POST" enctype="multipart/form-data">
                  <div class="cursor flex flex-col items-center">
                      <div 
                        class="rounded-full border-2 border-blue-300 overflow-hidden" 
                        style="width: 150px; height: 150px;">
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
                      >
                      <input type="text" name="info" class="focus:outline-none focus:border-blue-400 border-gray-300 p-2 border rounded" placeholder="Name" 
                        value="<?php echo $info; ?>"
                      
                      >
                  </div>
                  <div class="flex items-center justify-end p-6 border-solid border-blueGray-200 rounded-b">
                        <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id')">
                          Cancel
                        </button>
                        <?php if ($update == false): ?>
                          <button name="save" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-3 py-2 bg-green-400 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Submit
                          </button>
                         <?php else: ?>
                            <button name="update" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-3 py-2 bg-green-400 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                          </button>
                        <?php endif; ?>
                      </div>
                    </div>
                   </form>
                </div>
                <!--footer-->
            </div>
          </div>
          <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>
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
         <script type="text/javascript">
            function toggleModal(modalID){
              document.getElementById(modalID).classList.toggle("hidden");
              document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
              document.getElementById(modalID).classList.toggle("flex");
              document.getElementById(modalID + "-backdrop").classList.toggle("flex");
            }
          </script>
</html>
