<!DOCTYPE html>
<html>
     <head>
          <title></title>
          <style>
.post {
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: auto auto auto;
  gap: 10px;
  border: 1px solid #ddd;
  padding: 10px;
}

.post-header {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 10px;
}

.post-header img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}

.post-content img {
  width: 100%;
  max-width: 500px;
  margin: 10px 0;
}

.post-footer {
  display: grid;
  grid-template-columns: repeat(3, auto);
  gap: 10px;
}

          </style>
     </head>
     <body>
     <div class="post">
  <div class="post-header">
    <img src="avatar.jpg" alt="User Avatar">
    <div class="post-header-info">
      <h2>John Doe</h2>
      <p>January 16, 2023</p>
    </div>
  </div>
  <div class="post-content">
    <p>This is the post content. It can be as long or as short as you want.</p>
    <img src="post-image.jpg" alt="Post Image">
  </div>
  <div class="post-footer">
    <button>Like</button>
    <button>Comment</button>
    <button>Share</button>
  </div>
</div>

     </body>
</html>