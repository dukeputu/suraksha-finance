<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>@yield('title', 'MLM')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
   
    <link href="{{ asset('admin/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
   
    <link href="{{ asset('admin/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
    {{-- <link href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" /> --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">


<style>
  .from-top-header{
    text-align: center;
    font-size: 20px;
    font-weight: 700;
    background: #3c8dbc;
    color: #fff;
    display: block;
    border-radius: 20px;
  }
</style>


<style>
  .flash-message {
      padding: 15px 20px;
      margin: 20px 0;
      border-radius: 6px;
      font-size: 16px;
      top: -65px;
     width: 100%;
      position: absolute;
      animation: fadeIn 0.5s ease-in-out;
  }

  .flash-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
  }

  .flash-error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
  }

  .flash-message .close-btn {
      position: absolute;
      right: 10px;
      top: 10px;
      font-size: 20px;
      background: none;
      border: none;
      cursor: pointer;
      color: inherit;
  }

  @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
  }
</style>


{{-- Pritam --}}


    <style>
        
                html {
    overflow-y: scroll;
}
         .color-change1 {
    animation: colorCycle 5s infinite linear;
}

@keyframes colorCycle {
    0% { color: #e74c3c; }
    25% { color: #f39c12; }
    50% { color: #2ecc71; }
    75% { color: #3498db; }
    100% { color: #9b59b6; }
}
    </style>
    <style type="text/css"> 
#mydiv {
    position:absolute;
    top: 50%;
    left: 50%;
    width:30em;
    height:18em;
    margin-top: -9em; /*set to a negative number 1/2 of your height*/
    margin-left: -15em; /*set to a negative number 1/2 of your width*/
    border: 1px solid #ccc;
    background-color: #f3f3f3;
}
<style>
     .shadow {
            border: 5px solid #00a65a; /* Blue border */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Shadow effect */
            padding: 20px;
            margin: 10px;
            transition: transform 0.3s;
        } 
    </style>




        <!--pRITAM  -->
    <style>
    .small-box {
    border-radius: 25px;
}

.widget-user-2 .widget-user-header {
    border-top-right-radius: 25px;
    border-top-left-radius: 25px;
}
.box-widget {
    border-radius: 30px 30px 0 0;
}

.small-box .icon .ion {
    margin-top: 12px;
        color: #fff;
    opacity: 0.5;
}

.sidebar-menu, .main-sidebar .user-panel, .sidebar-menu>li.header {

    font-weight: 700;
}

.small-box>.small-box-footer {
    background: unset;
}
  
  .box-header .color-change
  {
    font-size: 28px;
    font-weight: 700;
}
   

   
     .small-box {
      color: white;
      padding: 5px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      position: relative;
      overflow: hidden;
      animation: fadeInUp 0.6s ease both;
    }

  

    .card:nth-child(5) { background: linear-gradient(135deg, #7c3aed, #8b5cf6); }
    .card:nth-child(6) { background: linear-gradient(135deg, #0d9488, #14b8a6); }
    .card:nth-child(7) { background: linear-gradient(135deg, #92400e, #f97316); }
    .card:nth-child(8) { background: linear-gradient(135deg, #9d174d, #ec4899); }
    
       .bg-aqua {    
    background: linear-gradient(135deg, #4f46e5, #3b82f6) !important;
}
    
       .bg-green{
    background: linear-gradient(135deg, #059669, #10b981) !important; 
}

       .bg-yellow{
    background: background: linear-gradient(135deg, #d97706, #f59e0b) !important; 
}
 
        .bg-red{
    background: background: linear-gradient(135deg, #b91c1c, #ef4444) !important; 
}   

    .label {
      font-size: 14px;
      text-transform: uppercase;
      opacity: 0.85;
    }

    .inner .color-change {
      font-size: 32px;
      font-weight: bold;
      margin: 8px 0;
      animation: pulse 8s infinite;
    }

    

    .card-bottom {
      font-size: 12px;
      opacity: 0.8;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
        opacity: 1;
      }
      50% {
        transform: scale(1.05);
        opacity: 0.95;
      }
    }

    @media (max-width: 600px) {
      .value {
        font-size: 24px;
      }
   
  
  
    </style>


    <style>




    .small-box::before{
      content: "";
      position: absolute;
      height: 2px;
      width: 100%;
      top: 0;
      left: -100%;
      background: linear-gradient(to right, white, cyan, white);
      animation: moveRight 2s linear infinite;
    }

    .small-box::after{
      content: "";
      position: absolute;
      width: 2px;
      height: 100%;
      right: 0;
      top: -100%;
      background: linear-gradient(to bottom, white, cyan, white);
      animation: moveDown 2s linear infinite 0.5s;
    }
 

    .small-box .bottom-line {
      content: "";
      position: absolute;
      height: 2px;
      width: 100%;
      bottom: 0;
      right: -100%;
      background: linear-gradient(to left, white, cyan, white);
      animation: moveLeft 2s linear infinite 1s;
    }

    .small-box .left-line {
      content: "";
      position: absolute;
      width: 2px;
      height: 100%;
      left: 0;
      bottom: -100%;
      background: linear-gradient(to top, white, cyan, white);
      animation: moveUp 2s linear infinite 1.5s;
    }

    /* Keyframes */
    @keyframes moveRight {
      0% { left: -100%; }
      50% { left: 0%; }
      100% { left: 100%; }
    }

    @keyframes moveDown {
      0% { top: -100%; }
      50% { top: 0%; }
      100% { top: 100%; }
    }

    @keyframes moveLeft {
      0% { right: -100%; }
      50% { right: 0%; }
      100% { right: 100%; }
    }

    @keyframes moveUp {
      0% { bottom: -100%; }
      50% { bottom: 0%; }
      100% { bottom: 100%; }
    }
  </style>

  <style>
   table.dataTable {
      border-radius: 12px;
      overflow: hidden;
      background-color: #fff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    table.dataTable thead th {
      background: #5b368e;
      color: white;
      font-weight: bold;
      text-align: center;
    }

    table.dataTable tbody td {
      text-align: center;
      font-size: 14px;
    }

    table.dataTable tbody tr:hover {
      background-color: #f3f3f3;
      transition: 0.3s ease-in-out;
    }

    .dataTables_wrapper .dataTables_filter input {
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 6px 10px;
    }

    .dataTables_wrapper .dataTables_length select {
      border-radius: 6px;
      padding: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 5px 10px;
      margin: 2px;
      border-radius: 6px;
      background-color: #5b368e;
      color: white !important;
      border: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background-color: #333 !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #333 !important;
    color: #fff !important;
}
  
  </style>

  <style>
   .content-header {
            background-color: #ffffff !important;
            padding: 20px 30px;
            border-bottom: 2px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0 0 10px 10px;
        }
        
        ol.breadcrumb {
    border-radius: 10px !important;
}

        .content-header h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
            font-weight: 700;
        }

        .content-header h1 small {
            font-size: 16px;
            color: blue;
        }

        .content-header a.btn-view {
            background-color: #1e7e34;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .content-header a.btn-view:hover {
            background-color: #155d27;
        }

        .content {
            padding: 30px;
        }

        .content .box-default {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 0px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e7e34;
            box-shadow: 0 0 5px rgba(30, 126, 52, 0.4);
        }

        .btn-primary, .breadcrumb a {
            background-color: #1e7e34;
            border: none;
            color: white;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #155d27;
        }

        @media (max-width: 768px) {
            .form-group.row .col-md-4 {
                width: 100%;
                margin-bottom: 15px;
            }
        }
  </style>

  <style>
  .main-sidebar {
      width: 250px;
      height: 100vh;
      background-color: #1f2d3d;
      position: fixed;
      /* padding: unset; */
      top: 0;
      left: 0;
      overflow-y: auto;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
    }

    .main-sidebar .sidebar {
      padding: 20px 0;
    }

    .main-sidebar .sidebar-menu {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-menu li {
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-menu a {
      color: #cfd8dc;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      font-size: 16px;
      transition: background-color 0.3s;
      position: relative;
    }

 

    .sidebar-menu a i {
      margin-right: 10px;
    }

    .sidebar-menu .treeview-menu {
      display: none;
      background-color: #263238;
    }
    

    .label-primary {
      background-color: #42a5f5;
      border-radius: 10px;
      padding: 2px 8px;
      font-size: 12px;
      color: white;
      position: absolute;
      right: 15px;
      top: 12px;
    }

    .sidebar-header {
      background-color: #1976d2;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      color: #fff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    
      @media (max-width: 768px) {
            .main-sidebar {
      width: 220px;
      box-shadow: unset;
    }
    
    .content-header {
 
    padding: 20px 15px;
    margin-right: 40px;
}

.content-header h1 {
    font-size: 16px;
    margin-right: 58px;
}

.content-header>.breadcrumb {
    padding-left: 0px;
}

.main-sidebar {
    overflow-y: unset;
}

        }
        
        
        
        @media (max-width: 600px) 
        {
            
            
            .day-box {
    padding: unset !important;
    min-width: 60px !important;
   
}
    .day-box {
        width: 60px !important;
        height: 41px !important;
        font-size: 14px;
    }
}
  </style>

  <style>
       

        .day-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0px;
            padding: 18px;
            background: #fff;
            border-radius: 12px;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .day-box {
            padding: 14px 20px;
            border-radius: 10px;
            min-width: 90px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
       
            background: linear-gradient(145deg, #2980b9, #27ae60);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .day-box:hover {
            transform: scale(1.06);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
        }

        .day-yellow {
            background: linear-gradient(145deg, #f39c12, #f1c40f);
        }

        .day-green {
            background: linear-gradient(145deg, #27ae60, #2ecc71);
        }

       .form-control {
            /* padding: unset; */
}
    </style>

  </head>