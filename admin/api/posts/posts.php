<script>
function timeAgo(postedTime) {
  const postedDate = new Date(postedTime);
  const currentDate = new Date();
  const timeDifference = currentDate - postedDate;

  const seconds = Math.floor(timeDifference / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);
  const months = Math.floor(days / 30);
  const years = Math.floor(days / 365);

  if (years > 0) {
      return `${years} year${years > 1 ? 's' : ''} ago`;
  } else if (months > 0) {
      return `${months} month${months > 1 ? 's' : ''} ago`;
  } else if (days > 0) {
      return `${days} day${days > 1 ? 's' : ''} ago`;
  } else if (hours > 0) {
      return `${hours} hour${hours > 1 ? 's' : ''} ago`;
  } else if (minutes > 0) {
      return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
  } else {
      return 'just now';
  }
}


async function fetchPosts() {
  return new Promise((resolve, reject) => {
      $.ajax({
          url: "./api/posts/get-user-posts.php",
          type: "POST",
          data: {
            uid: <?php echo  $profileUid; ?>
          },
          success: (data) => {
              resolve(JSON.parse(data));
          },
          error: (error) => {
     
              reject(error);
          }
      });
  });
}

  async function renderPosts() {
  
      const postData = await fetchPosts();
      const postPlace = document.querySelector(".mid-body");
      console.log(postData.length);
      if(postData.length > 0)
      {

        postData.forEach(postItem => {
              generatePostHTML(postItem);
        });

        
      }else{
        postPlace.innerHTML += "No Posts";
      }
      
  }

function generatePostHTML(postItem) {
  const postHTML = `
  
            <div class="post-item">
              <div class="post-item-head">
                <div class="post-item-head-left">
                  <img class="profile-picture-holder" src="../${postItem.profile_picture}" alt="" srcset="">
                </div>
                <div class="post-item-head-right">
                  <div class="post-user">
                    <span>${postItem.fname + " " + postItem.lname}</span>
                  </div>
                  <div class="post-details">
                    <span>${postItem.visibility}</span>
                    <span>|</span>
                    <span>${timeAgo(postItem.created_date_time)}</span>
                  </div>
                </div>
              </div>
              <a href="./post.php?postId=${postItem.post_id}" class="post-item-body">
                <span style="margin:5px;">${postItem.content}</span>
                
                ${(postItem.media) ? '<img style="width:500px;object-fit:contain;border-radius:10px;" src="../' + postItem.media+'" alt="" srcset=""' : ''}
          
              </a>
              <div class="post-item-footer">
                  <div class="like-container">
                  <img height="30px" src="../assets/images/heart-outline.png"></img>
                    <span class="like-count">${postItem.like_count}</span>
                  </div>
                  <div class="comment-container">
                  <img height="30px" src="../assets/images/comment-outline.png"></img>
                  <span class="like-count">${postItem.comments_count}</span>

                </div>
                </div>
                
              </div>
            </div>
          `;

  // Each iteration ma post item append garni
  document.querySelector("#post-container").innerHTML += postHTML;
 
}

renderPosts();


</script>

