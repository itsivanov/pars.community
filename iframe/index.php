

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="javascript.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" />


<div class="content">
		<!-- Область для перетаскивания -->
		<div id="drop-files" ondragover="return false">
			<p>Drag an image here</p>
	        <form id="frm">
	        		<input type="file" id="uploadbtn" multiple />
	        </form>
		</div>
	    <!-- Область предпросмотра -->
		<div id="uploaded-holder">
				<div id="dropped-files">
	        	<!-- Кнопки загрузить и удалить, а также количество файлов -->
	      		<div id="upload-button">
	          	<center>
                	<span>0 Files</span>
									<a href="#" class="upload">Upload</a>
									<a href="#" class="delete">Delete</a>
                    <!-- Прогресс бар загрузки -->
                	<div id="loading">
											<div id="loading-bar">
													<div class="loading-color"></div>
											</div>
											<div id="loading-content"></div>
									</div>
	            </center>
							</div>
	      </div>
		</div>
		<!-- Список загруженных файлов -->
		<div id="file-name-holder">
				<ul id="uploaded-files">
						<h1>Uploaded files</h1>
				</ul>
		</div>
</div>
