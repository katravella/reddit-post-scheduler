
	<script type="text/javascript" src="static/js/showdown.js"></script>
	<script type="text/javascript" src="static/js/showdown-gui.js"></script>
	<style type="text/css">
		html,body {
			margin:0;
			padding:0;
			font-family: Helvetica, Arial, Verdana, sans-serif;
			font-size: 90%;
		}
		
		html {
			overflow: hidden;
		}
		
		textarea {
			font-family: monospace;
		}
		
		#pageHeader {
			margin: 0;
			padding: 0;
			text-align: center;
			margin-bottom: 0;
			margin-top: 0.4em;
			color: #766;
		}
		
		#pageHeader h1 {
			font-size: 3em;
		}
		
		#pageHeader * {
			margin: 0;
			padding: 0;
			line-height: 1em;
			font-weight: 100;
		}

		#pageHeader a {
			color: #766;
			text-decoration: none;
			position: relative;
			z-index: 20;
		}

		#pageHeader h1 a:hover {
			color: #fff;
		}
		
		#pageHeader h4 a:hover {
			text-decoration: underline;
		}

		#leftContainer, #rightContainer {
			margin: 0;
			padding: 0;
			position: relative;
			width: 47.5%;
			margin-top: -1.4em;
		}
		
		#leftContainer {
			float: left;
			left: 1.5%;
		}
		
		#rightContainer {
			float: right;
			right: 1.5%;
		}
		
		#rightContainer > * {
			float: right;
		}
		
		.paneHeader {
			margin: 0;
			padding: 0;
			position: relative;
			width: 100%;
			display: block;
			height: 2em;
		}
		
		.paneHeader * {
			position: relative;
			font-weight: 900;
		}
		
		.paneHeader span {
			background-color: #ddd5d5;
			color: #444;
			padding: 0 0.75em;
			font-size: 110%;
		}
		
		#paneSetting {
			float: right;
			display: block;
			margin-left: auto;
			margin-right: 0.5em;
			font-size: 110%;
			font-weight: 900;
			font-family: Arial, Verdana, sans-serif;
			background-color: #dacccc;
			color: #444;
			border: 1px solid #999;
		}
		
		.pane {
			margin: 0;
			padding: 0;
			padding-left: 4px; /* pane padding */
			width: 100%;
			border: none;
			background-color: #eee;
			display: block;
			border: 1px solid #888;
			border-right: 1px solid #000;
			border-bottom: 1px solid #000;
		
			/* note: the panes get their height set with
		       javascript; see sizeTextAreas(). */
		
			/* for now, set a height so things look nice
			   if the user has javascript disabled */
			height: 400px;
		}
		
		#previewPane {
			background-color: #f3eeee;
		}
		
		#outputPane {
			background-color: #6c6666;
			color: #fff;
			display: none;
		}
		
		#syntaxPane {
			background-color: #e6dede;
			background-color: #f7ecec;
			display: none;
		}
		
		div.pane {
			overflow: auto;
		}
		
		#inputPane {
			background-color: #fff;
		}
		
		#previewPane {
			padding: 0;
		}

		#previewPane > * {
			margin-left: 4px;
			margin-right: 4px;
   		}

		#previewPane > blockquote {
			margin-left: 3em;
   		}

		#previewPane > :first-child {
			margin-top: 4px; /* pane padding */
		}

		#previewPane * {
			line-height: 1.4em;
		}

		#previewPane code {
			font-size: 1.3em;
		}
		
		#footer {
			margin: 0;
			padding: 0;
			position: relative;
			float: left;
			width: 100%;
			height: 2.5em;
			margin-top: 0.5em;
			font-family: Helvetica, Arial, Verdana, sans-serif;
		}
		
		#footer a {
			text-decoration: none;
			color: #666;
		}
		
		#footer a:hover {
			text-decoration: underline;
		}
		
		#byline {
			padding-left: 2em;
			color: #666;
		}
		
		#convertTextControls {
			position: absolute;
			right: 5em;
		}
		
		#convertTextButton {
			line-height: 1em;
			background-color: #ccbfbf;
			color: #000;
			border: none;
		}
		
		#convertTextButton:hover {
			background-color: #fff;
			color: black;
		}
		
		#convertTextSetting {
			background-color: #dacccc;
			color: #222;
			border: 1px solid #999;
		}
		
		#processingTime {
			margin: 0;
			padding: 0;
			width: 4em;
			text-align: right;
			color: #999;
			position: absolute;
			right: 1em;
			top: 0;
		}

		.no-select {
			-webkit-user-select: none;
			   -moz-user-select: none;
				-ms-user-select: none;
				 -o-user-select: none;
					user-select: none;
					  cursor: default;
		}

		.no-display {
			display: none;
		}
	</style>
	<div id="pageHeader" class="no-select">
		<h4><?=$url;?></h4>
	</div>
	<form action="<?=base_url()?>schedule/step5" method="post">
	<input type="hidden" name="sub" value="<?=$sub;?>">
	<input type="hidden" name="url" value="<?=$url;?>">
	
	<div id="leftContainer">
		<div class="paneHeader">
			<span>Input</span>
		</div>
		<textarea id="inputPane" cols="80" rows="20" name="markdownToPost" class="pane"><?=$markdown;?></textarea> 
	</div>

	<div id="rightContainer">
		<div class="paneHeader">
			<select id="paneSetting">
				<option value="previewPane">Preview</option>
				<option value="outputPane">HTML Output</option>
				<option value="syntaxPane">Syntax Guide</option>
			</select>
		</div>
	
		<textarea id="outputPane" class="pane" cols="80" rows="20" readonly="readonly"></textarea>
	
		<div id="previewPane" class="pane"><noscript><h2>You'll need to enable Javascript to use this tool.</h2></noscript></div>

<textarea id="syntaxPane" class="pane" cols="80" rows="20" readonly="readonly">

Markdown Syntax Guide
=====================

This is an overview of Markdown's syntax.  For more information, visit the [Markdown web site].

 [Markdown web site]:
   http://daringfireball.net/projects/markdown/






Italics and Bold
================


*This is italicized*, and so is _this_.

**This is bold**, and so is __this__.

You can use ***italics and bold together*** if you ___have to___.






Links
=====


Simple links
------------

There are three ways to write links.  Each is easier to read than the last:

Here's an inline link to [Google](http://www.google.com/).
Here's a reference-style link to [Google] [1].
Here's a very readable link to [Yahoo!].

  [1]: http://www.google.com/
  [yahoo!]: http://www.yahoo.com/

The link definitions can appear anywhere in the document -- before or after the place where you use them.  The link definition names (`1` and `Yahoo!`) can be any unique string, and are case-insensitive; `[Yahoo!]` is the same as `[YAHOO!]`.


Advanced links: Title attributes
--------------------------------

You can also add a `title` attribute to a link, which will show up when the user holds the mouse pointer it.  Title attributes are helpful if your link text is not descriptive enough to tell users where they're going.  (In reference links, you can use optionally parentheses for the link title instead of quotation marks.)

Here's a [poorly-named link](http://www.google.com/ "Google").
Never write "[click here][^2]".
Trust [me].

  [^2]: http://www.w3.org/QA/Tips/noClickHere
        (Advice against the phrase "click here")
  [me]: http://www.attacklab.net/ "Attacklab"


Advanced links: Bare URLs
-------------------------

You can write bare URLs by enclosing them in angle brackets:

My web site is at &lt;http://www.attacklab.net&gt;.

If you use this format for email addresses, Showdown will encode the address to make it harder for spammers to harvest.  Try it and look in the *HTML Output* pane to see the results:

Humans can read this, but most spam harvesting robots can't: &lt;me@privacy.net&gt;






Headers
=======


There are two ways to do headers in Markdown.  (In these examples, Header 1 is the biggest, and Header 6 is the smallest.)

You can underline text to make the two top-level headers:

Header 1
========

Header 2
--------

The number of `=` or `-` signs doesn't matter; you can get away with just one.  But using enough to underline the text makes your titles look better in plain text.

You can also use hash marks for all six levels of HTML headers:

# Header 1 #
## Header 2 ##
### Header 3 ###
#### Header 4 ####
##### Header 5 #####
###### Header 6 ######

The closing `#` characters are optional.






Horizontal Rules
================


You can insert a horizontal rule by putting three or more hyphens, asterisks, or underscores on a line by themselves:

---

*******
___

You can also use spaces between the characters:

-  -  -  -

All of these examples produce the same output.






Lists
=====


Simple lists
------------

A bulleted list:

- You can use a minus sign for a bullet
+ Or plus sign
* Or an asterisk

A numbered list:

1. Numbered lists are easy
2. Markdown keeps track of the numbers for you
7. So this will be item 3.

A double-spaced list:

- This list gets wrapped in `&lt;p&gt;` tags

- So there will be extra space between items


Advanced lists: Nesting
-----------------------

You can put other Markdown blocks in a list; just indent four spaces for each nesting level.  So:

1. Lists in a list item:
    - Indented four spaces.
        * indented eight spaces.
    - Four spaces again.

2.  Multiple paragraphs in a list items:

    It's best to indent the paragraphs four spaces
    You can get away with three, but it can get
    confusing when you nest other things.
    Stick to four.

    We indented the first line an extra space to align
    it with these paragraphs.  In real use, we might do
    that to the entire list so that all items line up.

    This paragraph is still part of the list item, but it looks messy to humans.  So it's a good idea to wrap your nested paragraphs manually, as we did with the first two.

3. Blockquotes in a list item:

    &gt; Skip a line and
    &gt; indent the &gt;'s four spaces.

4. Preformatted text in a list item:

        Skip a line and indent eight spaces.
        That's four spaces for the list
        and four to trigger the code block.






Blockquotes
===========


Simple blockquotes
------------------

Blockquotes are indented:

&gt; The syntax is based on the way email programs
&gt; usually do quotations. You don't need to hard-wrap
&gt; the paragraphs in your blockquotes, but it looks much nicer if you do.  Depends how lazy you feel.


Advanced blockquotes: Nesting
-----------------------------

You can put other Markdown blocks in a blockquote; just add a `&gt;` followed by a space:

Parragraph breaks in a blockquote:

&gt; The &gt; on the blank lines is optional.
&gt; Include it or don't; Markdown doesn't care.
&gt;
&gt; But your plain text looks better to
&gt; humans if you include the extra `&gt;`
&gt; between paragraphs.


Blockquotes within a blockquote:

&gt; A standard blockquote is indented
&gt; &gt; A nested blockquote is indented more
&gt; &gt; &gt; &gt; You can nest to any depth.


Lists in a blockquote:

&gt; - A list in a blockquote
&gt; - With a &gt; and space in front of it
&gt;     * A sublist

Preformatted text in a blockquote:

&gt;     Indent five spaces total.  The first
&gt;     one is part of the blockquote designator.






Images
======


Images are exactly like links, but they have an exclamation point in front of them:

 ![Valid XHTML] (http://w3.org/Icons/valid-xhtml10).

The word in square brackets is the alt text, which gets displayed if the browser can't show the image.  Be sure to include meaningful alt text for blind users' screen-reader software.

Just like links, images work with reference syntax and titles:

 This page is ![valid XHTML][checkmark].

 [checkmark]: http://w3.org/Icons/valid-xhtml10
           "What are you smiling at?"


**Note:**

Markdown does not currently support the shortest reference syntax for images:

  Here's a broken ![checkmark].

But you can use a slightly more verbose version of implicit reference names:

  This ![checkmark][] works.

The reference name (`valid icon`) is also used as the alt text.






Inline HTML
===========


If you need to do something that Markdown can't handle, you can always just use HTML:

 Strikethrough humor is &lt;strike&gt;funny&lt;/strike&gt;.

Markdown is smart enough not to mangle your span-level HTML:

&lt;u&gt;Markdown works *fine* in here.&lt;/u&gt;

Block-level HTML elments have a few restrictions:

1. They must be separated from surrounding text by blank
   lines.
2. The begin and end tags of the outermost block element
   must not be indented.
3. You can't use Markdown within HTML blocks.

So:

&lt;div style="background-color: lightgray"&gt;
    You can &lt;em&gt;not&lt;/em&gt; use Markdown in here.
&lt;/div&gt;






Preformatted Text
=================


You can include preformatted text in a Markdown document.

To make a code block, indent four spaces:

    printf("goodbye world!");  /* his suicide note
                                  was in C */

The text will be wrapped in `&lt;pre&gt;` and `&lt;code&gt;` tags, and the browser will display it in a monospaced typeface.  The first four spaces will be stripped off, but all other whitespace will be preserved.

You cannot use Markdown or HTML within a code block, which makes them a convenient way to show samples of Markdown or HTML syntax:

    &lt;blink&gt;
       You would hate this if it weren't
       wrapped in a code block.
    &lt;/blink&gt;






Code Spans
==========


You can make inline `&lt;code&gt;` tags by using code spans.  Use backticks to make a code span:

 Press the `&lt;Tab&gt;` key, then type a `$`.

(The backtick key is in the upper left corner of most keyboards.)

Like code blocks, code spans will be displayed in a monospaced typeface.  Markdown and HTML will not work within them:

 Markdown italicizes things like this: `I *love* it.`

 Don't use the `&lt;font&gt;` tag; use CSS instead.

</textarea>

	</div>
	<input type="submit" value="This looks good!">
	</form>
	<div id="footer">

		<span id="convertTextControls" class="no-display">
			<button id="convertTextButton" type="button" title="Convert text now">
				Convert text
			</button>
			
			<select id="convertTextSetting">
				<option value="delayed">in the background</option>
				<option value="continuous">every keystroke</option>
				<option value="manual">manually</option>
			</select>
		</span>
		<div id="processingTime" title="Last processing time">0 ms</div>
	</div>
	