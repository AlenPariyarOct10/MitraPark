<div id="mid-body" class="mid-body">
    <form id="postForm" method="POST" action="./server/api/uploadPost.php" class="add-post"
        enctype="multipart/form-data">
        <div class="post-upper">
            <img class="profile-picture-holder" src="<?php echo "./" . $_SESSION['user']['profile_picture']; ?>">
            <textarea name="post-text" id="post-text"></textarea>
        </div>
        <hr>
        <div class="post-bottom">
            <select style="cursor: pointer;" name="visibile-mode" class="post-bottom-element" id="reach-select">
                <option value="public">Public</option>
                <option value="private">Private</option>
                <option value="mitras">Mitra's</option>
            </select>
            <div style="cursor: pointer;" class="post-bottom-element">
                <label style="cursor: pointer;" for='file'>Photo</label>
                <input type='file' accept=".jpg, .jpeg, .png" style='display: none;' name='file' id='file'>
            </div>
            <button type="submit" id="share-btn" class="post-bottom-element">
                Share
            </button>
        </div>
    </form>
    <div id="post-container">

    </div>
    <div id="popup-upload-post">
                <img class="modal-popup-head" height="80px" src="../assets/images/post.png" alt="" srcset="">
                <div class="post-uploader">
                    <div class="post-uploader-head">
                        <h3>Create post</h3>
                    </div>
                    <hr class="section-break-hr">
                    <div class="row-caption-container">
                        <textarea placeholder="Write something" id="post-caption"></textarea>
                    </div>
                    <div class="post-image-holder">
                    <div class="inner-post-image-holder">
                        <img class="post-upload-image" src="alen-profile.jpg" alt="">
                        <div id="remove-post-image">
                            <p>x</p>
                        </div>
                    </div>
                    </div>
                    
                    <div class="row-upload-controls post-upload-control">
                        <select name="" id="">
                            <option value="public">Public</option>
                            <option value="mitras">Mitras</option>
                            <option value="private">Private</option>
                        </select>
                        <input style="display: none;" type="file" name="post-upload-file" id="post-upload-file">
                        <button><label for="post-upload-file">Photo</label></button>
                        <button>Share</button>
                    </div>
                </div>
            </div>
</div>