# META
#### (title, keywords, description)

To ouput meta data on public app of your module's page, just use service `\App\Service\Meta`.

\App\Service\Meta::getData() in your public controller will return associative array:

```
['title' => '...', 'keywords' => '...', 'description' => '...']
```


Include meta on any admin module controller, use `\Admin\Service\Meta`.
```
'meta' =>\Admin\Service\Meta::editor($url)
```

And then just echo `<?=$vars['meta'];?>` in your edit template.
It will include meta edit form, and its save button will update meta-data for your page. 