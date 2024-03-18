<div id="mid-body" class="mid-body">
            <form id="postForm" method="POST" action="./server/api/uploadPost.php" class="add-post"
                enctype="multipart/form-data">
                <div class="post-upper">
                    <img class="profile-picture-holder" src="<?php echo "./".$_SESSION['user']['profile_picture']; ?>">
                    <textarea name="post-text" id="post-text"></textarea>
                </div>
                <hr>
                <div class="post-bottom">
                    <select name="visibile-mode" class="post-bottom-element" id="reach-select">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                        <option value="mitras">Mitra's</option>
                    </select>
                    <div class="post-bottom-element">
                        <label for='file'>Photo / Video</label>
                        <input type='file' accept=".jpg, .jpeg, .png" style='display: none;' name='file' id='file'>
                    </div>
                    <button type="submit" id="share-btn" class="post-bottom-element">
                        Share
                    </button>
                </div>
            </form>
</div>