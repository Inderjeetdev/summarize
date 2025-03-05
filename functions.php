<?php
// Function to summarize text by words and sentences
function textRankSummarize($text, $word_count = 50, $sentence_count = 3) {
    $sentences = explode(". ", $text);
    $total_sentences = count($sentences);
    
    if ($total_sentences <= $sentence_count) {
        return $text;
    }
    
    $sentence_summary = implode(". ", array_slice($sentences, 0, $sentence_count)) . ".";
    
    $words = explode(" ", $sentence_summary);
    if (count($words) > $word_count) {
        return implode(" ", array_slice($words, 0, $word_count)) . "...";
    }
    
    return $sentence_summary;
}

// Function to fetch all text from <p> tags and remove HTML tags
function fetchFullArticle($url) { 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
    $html = curl_exec($ch);
    curl_close($ch);
    
    preg_match_all('/<p>(.*?)<\/p>/s', $html, $matches);
    $text = implode(" ", $matches[1]);
    
    return strip_tags($text);
}
?>
