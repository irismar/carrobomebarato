<?php


					     
							$_SESSION['session_id']=time();
							if(isset($_SESSION["usuario"])){
								$_SESSION['nickname'] = $_SESSION["usuario"];
							}else{
							$_SESSION['nickname'] = "visitante";
								}
							header("Location: ./bb.php");
						