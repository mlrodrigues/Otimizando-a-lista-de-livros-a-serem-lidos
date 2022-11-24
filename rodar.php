 <?php 
   if(!empty($_POST['freehour']) and !empty($_POST['paginasperhour']) and !empty($_POST['months'])){
      $hour = $_POST['freehour'];
      $page = $_POST['paginasperhour'];
      $period = $_POST['months'];
   }
   else{
      $hour = 0;
      $page = 0;
      $period = 0;
   }

   shell_exec('cd C:\wamp64\www\TrabalhoOS');
   $output = shell_exec('C:\Users\maria\AppData\Local\Programs\Python\Python311\python.exe C:\wamp64\www\TrabalhoOS\ReadBestsellers.py '.$hour.' '.$page.' '.$period.'');
   header('location: index.php');
?> 