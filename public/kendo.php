<!DOCTYPE HTML>
<html>
    <head>
        <title>Basic usage</title>
        <link href="http://cdn.kendostatic.com/2011.3.1007/styles/examples.min.css" rel="stylesheet"/>
        <link href="http://cdn.kendostatic.com/2011.3.1007/styles/kendo.common.min.css" rel="stylesheet"/>
        <link href="http://cdn.kendostatic.com/2011.3.1007/styles/kendo.kendo.min.css" rel="stylesheet"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script src="http://cdn.kendostatic.com/2011.3.1007/js/kendo.all.min.js"></script>
    </head>
    <body>
        <div id="example" class="k-content">
            <form class="t-content">
            <div id="panel" class="t-content">
                <ul>
                    <li>
                        <label for="blog-title">Title:</label>
                        <input type="text" id="blog-title" value="Demo Title" />
                    </li>
                    <li>
                        <label for="blog-twitter">Twitter handle:</label>
                        <input type="text" id="blog-twitter" value="kendoui" class="t-input" />
                    </li>
                    <li>
                        <label for="blog-content">Content:</label>
                        <textarea id="blog-content" rows="4" cols="60">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</textarea>
                    </li>
                </ul>

                <button id="preview" class="k-button">Preview</button>
            </div>
                </form>

            <div id="blog-preview"></div>

            <script type="text/x-kendo-template" id="template">
                <h3 class="k-widget k-header">#= title #</h3>
                <article>
                    <img alt="#= twitter #" title="#= twitter #" width="73" height="73" class="t=widget"
                        src="http://api.twitter.com/1/users/profile_image?screen_name=#= twitter #&size=bigger" />
                    <h4>posted on <time>#= new Date().toLocaleDateString() #</time> by <strong>#= twitter #</strong></h4>
                    <p>#= content #</p>
                </article>
            </script>

            <script>
                var template = kendo.template($("#template").html());

                function preview() {
                    $("#blog-preview").html(template({
                        title: $("#blog-title").val(),
                        twitter: $("#blog-twitter").val(),
                        content: $("#blog-content").val()
                    }));
                }

                preview();

                $("#preview").click(preview);
            </script>

            <style scoped>
                #panel
                {
                    background-color: #f2f2f2;
                    color:#000;
                    margin: -50px -20px 30px;
                    padding: 50px 0 25px;
                    border-radius: 5px 5px 0 0;
                    border-bottom: 1px solid #dedede;
                }

                #panel input,
                #panel textarea
                {
                    font: inherit;
                }

                #example ul h3
                {
                    margin-bottom: 0.6em;
                    padding: 0;
                }

                #example ul
                {
                    list-style: none;
                    margin: 0;
                    padding: 0;
                }

                #example ul label
                {
                    display: inline-block;
                    vertical-align: top;
                    width: 110px;
                    padding: 0 8px;
                    text-align: right;
                }

                #preview
                {
                    margin-left: 129px;
                }

                #preview
                {
                    height: 26px;
                    width: 140px;
                }

                #example li
                {
                    margin: 0.4em 0;
                }

                #example h3.k-header
                {
                    margin: 1.4em 0 1em;
                    padding: .4em 1.4em;
                    font-size: 1.4em;
                    border-radius: 2px;
                }

                #blog-preview
                {
                    width: 84%;
                    margin: 0 auto 40px;
                }

                #blog-preview img
                {
                    float: left;
                    margin: 0 14px 0 0;
                    border: 3px solid #dedede;
                    -moz-border-radius: 3px;
                    -webkit-border-radius: 3px;
                    border-radius: 3px;
                }

                #blog-preview h4
                {
                    font-size: 10px;
                    font-weight: normal;
                    text-transform: uppercase;
                    color: #8d8d8d;
                    margin-top: 0;
                    border-bottom: 1px solid #dedede;
                }

                #blog-preview h4 strong
                {
                    color: #ed662e;
                }

                #blog-preview p,
                #blog-preview h4
                {
                    margin-left: 93px;
                }
            </style>
        </div>
    </body>
</html>