<?PHP
///////////////////// TEMPLATE Default /////////////////////
$template_active = <<<HTML

<div class="news">
				<div><strong>{title}</strong></div>
				<div class="story">{short-story}</div>
				<div class="active_news_links">[full-link]Read more •[/full-link]  [com-link]{comments-num} Comments[/com-link]</div>
				<div><em>Posted on {date} by {author}</em></div>
			</div>
HTML;


$template_full = <<<HTML

			<div class="news">
				<div><strong>{title}</strong></div>
				<div class="story">{full-story}</div>
				<div class="active_news_links">{comments-num} Comments</div>
				<div><em>Posted on {date} by {author}</em></div>
			</div>
HTML;


$template_comment = <<<HTML

			<div class="news">
				<div class="comment_author"> by <strong>{author}</strong> @ {date}</div>
				<div class="comment">{comment}</div>
			</div>
HTML;


$template_form = <<<HTML

				<table align="center" border="0" width="350" cellspacing="0" cellpadding="0">
					<tr>
						<td width="60">Name:</td>
						<td><input type="text" name="name" /></td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td><input type="text" name="mail" /> (optional)</td>
					</tr>
					<tr>
						<td>Smile:</td>
						<td>{smilies}
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<textarea cols="40" rows="6" id="commentsbox" name="comments"></textarea><br />
							<input type="submit" name="submit" value="Add My Comment" />
							<input type="checkbox" name="CNremember"  id="CNremember" value="1" /><label for="CNremember"> Remember Me</label> |
							<a href="javascript:CNforget();">Forget Me</a>
						</td>
					</tr>
				</table>
HTML;


$template_prev_next = <<<HTML
<p align="center">[prev-link]<< Previous[/prev-link] {pages} [next-link]Next >>[/next-link]</p>
HTML;
$template_comments_prev_next = <<<HTML
<p align="center">[prev-link]<< Older[/prev-link] ({pages}) [next-link]Newest >>[/next-link]</p>
HTML;
?>
