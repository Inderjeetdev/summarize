<?php 
require 'functions.php'; 
require 'header.php'; 

$summary = "";
$text = "";
$word_count = 50;
$sentence_count = 3;
$total_words = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['url'])) {
        $url = $_POST['url'];
        $text = fetchFullArticle($url);
    } else {
        $text = $_POST['text'] ?? '';
    }
    
    $word_count = intval($_POST['word_count'] ?? 50);
    $sentence_count = intval($_POST['sentence_count'] ?? 3);
    $total_words = str_word_count($text);
    $summary = textRankSummarize($text, $word_count, $sentence_count);
}

// Visitor counter
$counterFile = "counter.txt";
if (!file_exists($counterFile)) {
    file_put_contents($counterFile, 0);
}
$visitorCount = (int)file_get_contents($counterFile) + 1;
file_put_contents($counterFile, $visitorCount);
?>

<form method="post" action="">
    <div class="mb-3">
        <label class="form-label">Enter URL:</label>
        <input type="text" class="form-control" name="url" placeholder="Enter URL here...">
    </div>
    <div class="mb-3">
        <label class="form-label">OR Enter Text:</label>
        <textarea class="form-control" name="text" rows="5" placeholder="Enter your text here..."><?php echo htmlspecialchars($text); ?></textarea>
    </div>
    <p><strong>Total Words in Text:</strong> <?php echo $total_words; ?></p>
    <div class="mb-3">
        <label class="form-label">Number of Sentences:</label>
        <input type="number" class="form-control" name="sentence_count" value="<?php echo $sentence_count; ?>" min="1">
    </div>
    <div class="mb-3">
        <label class="form-label">Number of Words:</label>
        <input type="number" class="form-control" name="word_count" value="<?php echo $word_count; ?>" min="1">
    </div>
    <button type="submit" class="btn btn-primary w-100">Summarize</button>
</form>

<?php if (!empty($summary)) { ?>
    <div class="card shadow p-4 mt-4">
        <h3>Summary:</h3>
        <p><?php echo htmlspecialchars($summary); ?></p>
    </div>
<?php } ?>

<?php require 'footer.php'; ?>
