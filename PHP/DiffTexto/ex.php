<?php
    require('diff.php');
 
 $before = IsSet($_POST['before']) ? $_POST['before'] : 'texto';
 $after = IsSet($_POST['after']) ? $_POST['after'] : 'texto novo';
 $mode = (IsSet($_POST['mode']) ? $_POST['mode'] : 'w');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
<title>Diff</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<style type="text/css">
* { font-family: sans-serif,arial,helvetica }
.frameResults { border-style: solid; border-width: 1px; }
</style>
<body>
<form method="POST" action="?">
<div><label for="before">Antes</label><br>
<textarea id="before" cols="80" rows="10" name="before"><?php echo HtmlSpecialChars($before); ?></textarea></div>
<div><label for="after">Depois</label><br>
<textarea id="after" cols="80" rows="10" name="after"><?php echo HtmlSpecialChars($after); ?></textarea></div>
<div><input type="submit" name="compare" value="Comparar"> por <select name="mode">
<option value="c"<?php if($mode === 'c') echo ' selected'; ?>>Character</option>
<option value="w"<?php if($mode === 'w') echo ' selected'; ?>>Palavra</option>
<option value="l"<?php if($mode === 'l') echo ' selected'; ?>>Linha</option>
</select></div>
<?php
    if(IsSet($_POST['compare']))
    {
        $diff = new diff_class;
        $difference = new stdClass;
        $difference->mode = $mode;
        $difference->patch = true;
        $after_patch = new stdClass;
        if($diff->FormatDiffAsHtml($before, $after, $difference)
        && $diff->Patch($before, $difference->difference, $after_patch))
        {
            echo '<div>Diferenca</div><div class="frameResults">', $difference->html, '</div>';
            echo '<div>Patch</div><div class="frameResults">', ($after === $after_patch->after ? 'OK: Coincide.' : 'Diferente (<b>'.HtmlSpecialChars($after_patch->after).'</b>)Não é igual (<b>'.HtmlSpecialChars($after).'</b>).'), '</div>';
        }
        else
            echo '<div>Error: ', HtmlSpecialChars($diff->error), '</div>';
    }
?>
</form>
</body>
</html>