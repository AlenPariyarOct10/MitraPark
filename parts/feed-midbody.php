<div id="mid-body" class="mid-body">
    <div style="width: 100%;">
        <div id="postForm" class="add-post">
            <div class="post-upper">
                <img class="profile-picture-holder" src="<?php echo "./" . $_SESSION['user']['profile_picture']; ?>">
                <span name="post-text" id="post-text">Write something</textarea>
            </div>
        </div>
    </div>


    <div id="post-container">

    </div>
    <div id="modal-wrapper">
        <div id="popup-upload-post">
            <img class="modal-popup-head" height="80px" src="./assets/images/post.png" alt="" srcset="">
            <div class="post-uploader">
                <div id="closeModal">
                    <p>x</p>
                </div>
                <div class="post-uploader-head">
                    <h3>Create post</h3>
                </div>
                <hr class="section-break-hr">
                <form action="./server/api/uploadPost.php" method="POST" enctype="multipart/form-data">
                    <div class="row-caption-container">
                        <textarea name="post-text" style="color: #222831;" placeholder="Write something" id="post-caption"></textarea>
                    </div>
                    <div class="post-image-holder">
                        <div class="inner-post-image-holder">
                            <img id="selected-post-img" class="post-upload-image" src="" alt="">
                            <div id="remove-post-image">
                                <p>x</p>
                            </div>
                        </div>
                    </div>

                    <div class="row-upload-controls post-upload-control">
                        <select name="visibile-mode" id="visibile-mode">
                            <option value="public">Public</option>
                            <option value="mitras">Mitras</option>
                            <option value="private">Private</option>
                        </select>
                        <input style="display: none;" type="file" accept=".jpg, .jpeg, .png" name="file" id="post-upload-file">
                        <button type="button"><label style="color:white; cursor:pointer;" for="post-upload-file">Photo</label></button>
                        <input id="post-share-btn" type="submit" value="Share">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>