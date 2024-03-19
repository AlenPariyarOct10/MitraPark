async function fetchPosts() {
  return new Promise((resolve, reject) => {
      $.ajax({
          url: "./server/api/get-posts.php",
          type: "POST",
          success: (data) => {
              console.log("data:");
              console.log(data);
              console.log(JSON.parse(data));
              resolve(JSON.parse(data));
          },
          error: (error) => {
              console.log("failed");
              reject(error);
          }
      });
  });
}


  

function likeHandeler() {
  let postLikes = document.querySelectorAll(".like-container");
  console.log(postLikes);
  postLikes.forEach((item) => {
      item.addEventListener("click", () => {
          console.log(item.dataset.id);
          console.log(item.childNodes[1].src);
          let id = item.dataset.id;
          let src = item.childNodes[1].src;
          let likeCount = item.childNodes[3];

          if (src.includes("assets/images/heart-solid.svg")) {
              likeCount.innerHTML = parseInt(likeCount.innerHTML) - 1;
              console.log(likeCount);
              item.childNodes[1].src = "./assets/images/heart-outline.svg";
          } else {
              likeCount.innerHTML = parseInt(likeCount.innerHTML) + 1;
              console.log(likeCount)
              item.childNodes[1].src = "./assets/images/heart-solid.svg";
          }

          $.ajax({
              url: "./server/api/addLike.php",
              type: "POST",
              data: { postId: id },
              success: (msg) => {
                  console.log(msg);

              },
              error: (msg) => {
                  console.log(msg);
                  localStorage.getItem("mp-uid");
              }
          });


      })
      console.log(item);
  })
}
  
  async function renderPosts() {
    try {
      const postData = await fetchPosts();
      const postPlace = document.querySelector(".mid-body");
      console.log(postData.length);
      if(postData.length > 0)
      {
        console.log("hereee");
        
        postData.forEach(postItem => {
          console.log("each");
          
          if(postItem.profile_picture == null)
          {
            postItem.profile_picture = "/MitraPark/assets/images/user.png";
          }
          $.ajax({
            url: "./server/api/getLikes.php",
            type: "POST",
            data: {postId: postItem.post_id},
            success: function(data)
            {
              let likesObj = JSON.parse(data);
              console.log("likes",likesObj);
              let liked_byObj= likesObj.map((item)=>item.liked_by);
              console.log(liked_byObj);

              let likedState = (liked_byObj.indexOf(localStorage.getItem("mp-uid")) != -1)?"./assets/images/heart-solid.svg":"./assets/images/heart-outline.svg";
              console.log("index",likedState);
              generatePostHTML(postItem, likedState);
            },
            error: function(data)
            {
              console.log("failed");
            }
          })
           
        });

        
      }else{
        postPlace.innerHTML += "No Posts";
      }
      
    } catch (error) {
      console.error("Error fetching or rendering posts:", error);
    }
  }

  // Function to generate post HTML with likedState parameter
function generatePostHTML(postItem, likedState) {
  const postHTML = `
            <div class="post-item">
              <div class="post-item-head">
                <div class="post-item-head-left">
                  <img class="profile-picture-holder" src="${postItem.profile_picture}" alt="" srcset="">
                </div>
                <div class="post-item-head-right">
                  <div class="post-user">
                    <span>${postItem.fname + " " + postItem.lname}</span>
                  </div>
                  <div class="post-details">
                    <span>${postItem.visibility}</span>
                    <span>|</span>
                    <span>${postItem.created_date_time} </span>
                  </div>
                </div>
              </div>
              <div class="post-item-body">
                <span>${postItem.content}</span>
                <img src=".${postItem.media}" alt="" srcset="">
              </div>
              <div class="post-item-footer">
              
                <div data-id=${postItem.post_id} class="like-container">
                  <img height="20px" src=${likedState}>
                  <span class="like-count">${postItem.like_count}</span>
                </div>
                <div class="comment-container">
                  <img height="20px" src="./assets/images/comment-outline.svg">
                </div>
              </div>
              <hr>
              <div class="comment-inp">
                  <input id="post-comment-${postItem.post_id}" placeholder="Write comment" type="text"/>
                  <button class="post-comment" onclick="postComment(${postItem.post_id})" id="comment-btn-${postItem.post_id}"> > </button>
                </div>
              <div>
                <a href="postLikes.php?postId=${postItem.post_id}">Likes</a>
                |
                <a href="postComments.php?postId=${postItem.post_id}">Comments</a>

              </div>
            </div>
          `;

  // Append the post HTML to the postPlace element
  document.querySelector(".mid-body").innerHTML += postHTML;
  likeHandeler();
}
  
// Call renderPosts
renderPosts().catch(error => {
  console.error("Error rendering posts:", error);
});
  
function postComment(id)
{  
  let commentText = document.getElementById("post-comment-"+id);
  $.ajax({
    url: "./server/api/insertComment.php",
    type: "POST",
    data: {postId: id, commentAuthor: localStorage.getItem("mp-uid") , commentContent: commentText.value},


  })

  console.log(commentText.value);
  commentText.value = null;
}
