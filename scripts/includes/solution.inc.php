<section>
    <h2 class="section-title"><i class="fa-solid fa-angles-right"></i> <?= html_entity_decode($solution['title']) ?></h2>
    <div class="tags">
        <?php $tags = json_decode(html_entity_decode($solution['tags']), true);
        foreach ($tags as $tag) { ?>
            <span class="tag">#<?= $tag ?></span>
        <?php } ?>
    </div>
    <div class="problem-box">
        <i class="fa-solid fa-quote-left"></i>
        <?= html_entity_decode($solution['problem']) ?>
        <i class="fa-solid fa-quote-right"></i>
    </div>

    <table id="input-output">
        <tr>
            <th>Example Input</th>
            <th>Expected Output</th>
        </tr>
        <?php
        $inputs = explode(":", $solution['example_input']);
        $outputs = explode(":", $solution['expected_output']);

        foreach ($outputs as $outputKey => $output) {
            $input = (array_key_exists($outputKey, $inputs)) ? $inputs[$outputKey] : "";
        ?>
            <tr>
                <td><?= $input ?></td>
                <td><?= $output ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="subsection solution">
        <h3 class="subsection-title">Solution</h3>
        <h4 class="section-subtitle">Approach</h4>
        <?= html_entity_decode($solution['approach']) ?>

        <h4 class="section-subtitle">Algorithm:</h4>
        <ul class="algorithm">
            <?= html_entity_decode($solution['algorithm']) ?>
        </ul>

        <h4 class="section-subtitle">Code:</h4>
        <pre><code class="language-c"><?= $solution['code'] ?></code></pre>
        <a href="ide.php?try=<?= $solution['id'] ?>&from=probs"><button id="try-code"> TRY CODE</button></a>

        <h4 class="section-subtitle">explanation:</h4>
        <ul class="explanation">
            <?= html_entity_decode($solution['explanation']) ?>
        </ul>

    </div>
</section>