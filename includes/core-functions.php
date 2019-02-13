<?php // Bible Press - Core Functions

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

// Bible Press Table of Contents (TOC)
function bible_press_toc($url)
{
    global $wpdb;
    $options = get_option('bible_press_options', bible_press_options_default());

    if (isset($options['old_testament_title']) && !empty($options['old_testament_title'])) {
        $old_testament_title = sanitize_text_field($options['old_testament_title']);
    }
    if (isset($options['new_testament_title']) && !empty($options['new_testament_title'])) {
        $new_testament_title = sanitize_text_field($options['new_testament_title']);
    }

    $str = "<div class=\"row\"><div class=\"column\">";
    $str .= "<h4>" . $old_testament_title . "</h4><ul>";

    $query = "SELECT * FROM books";
    $results = $wpdb->get_results($query);
    if ($results) {
        foreach ($results as $bookRow) {
            $bookID = $bookRow->bookID;
            $bookName = $bookRow->latinLongName;
            if ($bookID == 40) {   // New Testament starts at book 40
				$str .= "</ul></div><div class=\"column\"><h4>" . $new_testament_title . "</h4><ul>";
			}
			
			$str .= "<li><a href=\"?page_id=" . get_the_id() . "&ref=" . $bookID . ".1\">" . $bookName . "</a></l1>";
        }
    } else {
        $str .= esc_html__( 'No book found', 'bible-press' ) . "<br>";
    }
    $str .= "</ul></div></div>";
    return $str;
}
add_shortcode('biblepresstoc', 'bible_press_toc');


// Bible Press display a single chapter
function bible_press_show_chapter()
{
    global $wpdb;
    $aCrossRefs = null;
    $bookID = bible_press_get_book_id();
    $chapterID = bible_press_get_chapter_id();
    $sql = $str = $footnote = "";
    $footnoteCount = 1;
    $crossrefCount = 0;

    $query = "SELECT * FROM books WHERE bookID='" . $bookID . "'";
    $results = $wpdb->get_row($query);
    if ($results) {
        $bookID = $results->bookID;
        $bookName = $results->latinLongName;
        $str .= "<h2>" . $bookName . " " . $chapterID . "</h2>";
    } else {
        $str .= "No book found <br>";
    }

    $query = null;
    $query = "SELECT * FROM verseinfo as vi LEFT JOIN versesegment as vs on vi.verseID = vs.verseID ";
    $query .= "WHERE vi.bookID=" . $bookID . " and vi.chapterNum=" . $chapterID;
//    $str .= "Query=" . $query . "<br/>";
    $results = $wpdb->get_results($query);
    if ($results) {
        $str .= "<div><p>";
        $prevVerseID = "";
        $aCrossRefs = bible_press_get_crossrefs($bookID, $chapterID);
//        print_r( $aCrossRefs );
        foreach ($results as $verse) {
            $footnote = "";
            $segment = $verse->segmentText;
            if ($verse->beginParagraph == 1) {
                $str .= "</p><p>";
            }
            $verseID = $verse->verseID;

            if ($verse->displayVerse == 1 && $verseID != $prevVerseID) {
                $str .= " <span class=\"bp-verse-label\">" . $verse->verseLabel . "</span> ";
            }

            if ($verse->hasCrossReference == 1) {
                $str .= bible_press_show_crossref($aCrossRefs, $verseID);
            }

            if ($verse->hasFootnote == 1) {
                $footnote = "<sup><a href=\"#footnotes\" name=\"footnote\">[" . $footnoteCount++ . "]</a></sup>  ";
            }
            $str .= $segment . $footnote;
            $prevVerseID = $verseID;
        }
    }
    $str .= "</p></div>";
    $str .= bible_press_show_footnotes($bookID, $chapterID);

    return $str;
}
add_shortcode('biblepresschapter', 'bible_press_show_chapter');


// Bible Press - show all footnotes related to chapter
function bible_press_show_footnotes($bookID, $chapterID)
{
    global $wpdb;
    $sql = $str = "";
    $str .= "<a name=\"footnotes\"><hr></a><div class=\"bp-footnote\"><ol>";
//    $str .= "bookID=" . $bookID . " chapterID=" . $chapterID . "<br/>";
    $chapterID = str_pad($chapterID, 3, "0", STR_PAD_LEFT);

    $query = "SELECT * FROM footnotes WHERE SUBSTRING(footnoteID,1,6) = '" . $bookID . "." . $chapterID . "'";
//    $str .= "Query=" . $query . "<br/>";
    $results = $wpdb->get_results($query);
    if ($results) {
        foreach ($results as $footnote) {
            $footnote = $footnote->footnoteText;
            $str .= "<li>" . $footnote . "</li>";
        }
    }
    $str .= "</ol></div>";
    return $str;
}

// Bible Press - Select all CrossRefs associated with Chapter from Database; return an Object
function bible_press_get_crossrefs($bookID, $chapterID)
{
    global $wpdb;
    $chapterID = str_pad($chapterID, 3, "0", STR_PAD_LEFT);

    $query = "SELECT * FROM crossReferences WHERE SUBSTRING(crossReferenceID,1,6)='" . $bookID . "." . $chapterID . "'";
    $results = $wpdb->get_results($query);
    if ($results) {
        return $results;
    } else {
        return null;
    }
}

// Bible Press - Show single Cross as a popup;  See associated CSS and JS
function bible_press_show_crossref($aCrossRefs, $verseID)
{
    $str = "";
    $label = 'a';
    if (is_array($aCrossRefs)) {
        foreach ($aCrossRefs as $crossref) {
            $ref = substr($crossref->crossReferenceID, 0, 10);
            if ($ref == $verseID) {
                //    $label = $crossref->crossReferenceReference;
                $str .= "<span class=\"popup\" id=\"popup-" . $label . "\" onmouseover=\"showCrossRef(this);\" onmouseout=\"hideCrossRef(this);\">";
                $str .= "<sup>[" . $label . "]</sup>";
                $str .= "<span class=\"popuptext\" id=\"text-popup-" . $label . "\">" . $crossref->crossReferenceText . "</span></span>";
            }
            $label++;
        }
    }
    return $str;
}

// Bible Press - Get book and chapter reference from Querystring, and display two select lists
function bible_press_get_select_lists($atts)
{
    $a = shortcode_atts(array('submit' => 'submit'), $atts);
    global $wpdb;
	$bookID = bible_press_get_book_id();
	$str = "<form name=\"bookList\" action=\"\" method=\"get\">";
	$str .= "<input type=\"hidden\" id=\"page_id\" name=\"page_id\" value=\"" . get_the_id() . "\" >"; 
    $chapterCount = 1;

    $query = "SELECT * FROM books;";
    $results = $wpdb->get_results($query);
    if ($results) {
        $str .= "<select id=\"ref\" name=\"ref\" onchange=\"changeChapter(this.value)\">";
        foreach ($results as $book) {
            $str .= "<option value=\"" . $book->bookID . "\"";
            if ($book->bookID == $bookID) {
                $str .= " selected";
                $chapterCount = $book->chapterCount;
            }
            $str .= ">" . $book->latinLongName . "</option>";
        }
        $str .= "</select>";

        $chapterID = bible_press_get_chapter_id();
        $str .= "<select id=\"ch\"  name=\"ch\">";
        for ($i = 1; $i <= $chapterCount; $i++) {
            $str .= "<option value=\"" . $i . "\"";
            if ($i == $chapterID) {
                $str .= " selected";
            }
            $str .= ">" . $i . "</option>";
        }
        $str .= "</select>";
    }
    $str .= " <input type=\"submit\" name=\"submit\" value=\"" . $a['submit'] . "\"></form>";
    return $str;
}

add_shortcode('biblepressselect', 'bible_press_get_select_lists');


// Bible Press - Get book reference from Querystring
function bible_press_get_book_id()
{
    $bookID = "01";

    if ( isset( $_GET['ref']) ) {
        $refID = sanitize_key( $_GET['ref'] );
        $refID = substr($refID, 0, 2);
        if (is_numeric($refID)){
            $bookID = $refID;
        }
    }
    return $bookID;
}


// Bible Press - Get chapter reference from Querystring
// Query can be two formats.  If 'ch' is sent returns the chapter
// if 'ref' is set it returns the chapter part of the reference
// otherwise it returns the default of '01'
function bible_press_get_chapter_id()
{
    $chapterID = "01";

    if ( isset( $_GET['ch']) ) {
        $chID = sanitize_key( $_GET['ch'] );
        $chID = substr($chID, 0, 2);
        if (is_numeric($chID)){
            $chapterID = $chID;
        }
    } 
    
    if ( isset( $_GET['ref']) ) { // use ref query if querstring uses this format ?ref=01.12
        $refID = sanitize_key( $_GET['ref'] );
        if (strstr($refID, ".")) {
            $refID = substr($refID, 3, 3);
            if (is_numeric($refID)){
                $chapterID = $refID;
            }
        }
    }
    return $chapterID;
}
