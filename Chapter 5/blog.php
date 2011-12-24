<?php
require('log.php');
$start = microtime();

$id = $_GET['id'];

try {

    $connection = new Mongo();
    $database   = $connection->selectDB('myblogsite');
    $collection = $database->selectCollection('articles');

} catch(MongoConnectionException $e) {
    die("Failed to connect to database ".$e->getMessage());
}

$cursor  = $collection->find(array('_id' => new MongoId($id)));
$article = $cursor->getNext();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <link rel="stylesheet" href="style.css" />

      <title>My Blog Site</title>

      </head>

          <body>
              <div id="contentarea">
                  <div id="innercontentarea">                      
                      <h1><?php echo $article['title']; ?></h1>
                      <p><?php echo $article['content']; ?></p>
                      <div id="comment-section">                                                        
                           <?php if (!empty($article['comments'])): ?>
                                <h3>Comments</h3>
                                <?php foreach($article['comments'] as $comment):
                                    echo $comment['name'].' says...';?>
                                    <p><?php echo $comment['comment']; ?></p>
                                    <span><?php echo date('g:i a, F j', $comment['posted_at']->sec); ?></span><br/><br/><br/>
                                <?php endforeach;
                            endif;?>
                            <h3>Post your comment</h3>
                            <form action="comment.php" method="post">
                                <span class="input-label">Name</span> 
                                <input type="text" name="commenter_name" class="comment-input"/><br/><br/>
                                <span class="input-label">Email</span> 
                                <input type="text" name="commenter_email" class="comment-input"/><br/><br/>
                                <textarea name="comment" rows="5"></textarea><br/><br/>
                                <input type="hidden" name="article_id" value="<?php echo $article['_id']; ?>"/>
                                <input type="submit" name="btn_submit" value="Save"/>
                            </form>
                       </div>
                  </div>
              </div>
          </body>
</html>
<?php

$end = microtime();
$data = array('response_time_ms' => ($end - $start) * 1000);

$logger = new Logger();
$logger->logRequest($data);
$logger->updateVisitCounter($id);