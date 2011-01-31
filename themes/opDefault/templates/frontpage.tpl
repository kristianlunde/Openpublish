<div id="wrapper">

    <div id="header">
        <div id="logo">
            <h1>{siteName}</h1>
        </div>
        <!-- navigation -->
        {1:menu}
    </div><!--END header-->

    <div id="banner">

            {2:slides:700x600}
            {2:wrapStart}
            <div class="slide">
                {2:wrapContent}
            </div>
            {2:wrapEnd}

    </div><!--END banner-->

    <div id="content">

        <div id="three-cols">

            <div class="leftCol">
                {3:leftColumn:300}
            </div>

            <div class="midCol">
                {4:midColumn:300}
            </div>

            <div class="rightCol">
                {5:rightColumn:300}
            </div>

        </div><!--END three-cols-->

    </div><!--END content-->

    <div id="footer">
        <div class="copyright">Copyright &copy; 2009 {siteName}. All rights reserved.</div>
        <div class="powered"><a href="http://www.openpublish.org/" title="Openpublish CMS" target="_blank"><img src="{themePath}images/btn_oplogo.png" width="135" height="22" alt="" /></a></div>
    </div><!--END footer-->

</div><!--END wrapper-->