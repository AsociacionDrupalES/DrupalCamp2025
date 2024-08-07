TEMPLATES
---------
Da Vinci is using Classy as base theme so an override is as simple as copying
one of Classy's templates into your templates directory.

Remember to use the following twig template naming conventions:

- HTML:
  Base template: html.html.twig
  Some examples: html--internalviewpath.html.twig
                 html--node--id.html.twig
                 html.html.twig

- PAGE TEMPLATE:
  Pattern: page--[front|internal/path].html.twig
  Base template: page.html.twig
  Front page template: page--front.html.twig

  The list of suggested template files is in order of specificity based on
  internal paths. One suggestion is made for every element of the current path,
  though numeric elements are not carried to subsequent suggestions.
  For example, "http://www.example.com/node/1/edit" would result in the
  following suggestions:
    page--node--edit.html.twig
    page--node--1.html.twig
    page--node.html.twig
    page.html.twig

- REGIONS:
  Pattern: region--[region].html.twig
  Base template: region.html.twig

- BLOCKS:
  Pattern: block--[module|-delta]].html.twig
  Base template: block.html.twig
  For example: block--block--1.html.twig

- NODES:
  Pattern: node--[type|nodeid]--[viewmode].html.twig
  Base template: node.html.twig

- TAXONOMY TERMS:
  Pattern: taxonomy-term--[vocabulary-machine-name|tid].html.twig
  Base template: taxonomy-term.html.twig

- FIELDS:
  Pattern: field--[type|name[--content-type]|content-type].html.twig
  Base template: field.html.twig

- COMMENTS:
  Pattern: comment--node-[type].html.twig
  Base template: comment.html.twig

  and comment wrappers:
  Pattern: comment-wrapper--node-[type].html.twig
  Base template: comment-wrapper.html.twig

- FORUMS:
  Pattern: forums--[[container|topic]--forumID].html.twig
  Base template: forums.html.twig

- MAINTENANCE PAGE:
  Pattern: maintenance-page--[offline].html.twig
  Base template: maintenance-page.html.twig

- SEARCH RESULT:
  Pattern: search-result--[searchType].html.twig
  Base template: search-result.html.twig
