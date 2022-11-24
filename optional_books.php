<?php 
if( !(isset( $_GET['slug'] ) && $_GET['slug'] != '') ){
    echo "<script>window.history.back();</script>";
}
$slug = $_GET['slug'];
include 'include/head.php';
include 'DB.php';    
?>
<style>
    .bradcaump-content a, .bradcaump-content span {
        color: #000 !important;
    }
    .bradcaump-content span.active {
        color: #e59285 !important;
    }
    .bradcaump-content a:hover, h6 a {
        color: #e59285 !important;
    }
    
    h6 a {
        font-weight: 100;
    }
    
    h6 a:hover {
        color: #002 !important;
    }
    
    .heading {
        clear: both;
        font-size: 16px;
        margin: 10px 0;
        padding: 8px 0;
        font-weight: 600;
        border-bottom: 3px solid rgba(0,0,0,0.08);
    }
    .one_half {
        width: 50%;
        float: left;
        min-width: 240px;
    }
</style>
    <body>
        <div class="wrapper" id="wrapper">
        <?php 
                include 'include/header.php'; 
        ?>
        <div class="ht__bradcaump__area " style="padding-bottom: 0px; padding-top: 0px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title"><?= ucwords($slug); ?> Books</h2>
                            <nav class="bradcaump-content">
                              <a  style="color: #000;" class="breadcrumb_item" href="index.php">Home</a>
                              
								<span class="brd-separetor">/</span>
								<span class="breadcrumb_item active">Optional Books</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-blog-details section-padding--lg bg--white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <h2>Optional Books</h2>
                        Download <?= ucwords($slug); ?> books for all optional subjects from group i to vii.
                    </div>
                </div>
                <br>
                <div class="row" style="height: auto !important;">
            <div class="col-md-9 col-sm-8">
                <div class="content">
                    <p><strong></strong></p><h3 class="heading "><strong><span> <span style="color: #00ccff;">Optional Subjects Books</span>&nbsp;</span></strong></h3><br>
<div class="one_half "><div class="column_content "> <h3 class="heading "><span> GROUP&nbsp;I </span></h3><p></p>
<ul>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-accountancy-auditing">Accountancy &amp; Auditing</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-economics">Economics</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-computer-science">Computer Science</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-political-science">Political Science</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-international-relations">International Relations</a>&nbsp;</h6></li></ul></div></div>


<div class="one_half "><div class="column_content "> <h3 class="heading "><span> GROUP&nbsp;II </span></h3><p></p>
<ul>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-physics">Physics</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-chemistry">Chemistry</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-applied-mathematics">Applied Mathematics</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-pure-mathematics">Pure Mathematics</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-statistics">Statistics</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-geology">Geology</a>&nbsp;</h6></li></ul></div></div>


<p></p><h3 class="heading "><span> </span></h3><br>
<div class="one_half "><div class="column_content "> <h3 class="heading "><span> GROUP&nbsp;III </span></h3><p></p>
<ul>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-business-administration">Business Administration</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-public-administration">Public Administration</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-governance-public-policies">Governance &amp; Public Policies</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-town-planning-urban-management">Town Planning &amp; Urban-Management</a>&nbsp;</h6></li></ul></div></div>


<div class="one_half "><div class="column_content "> <h3 class="heading "><span> GROUP IV </span></h3><p></p>
<ul>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-history-of-pakistan-india">History of Pakistan &amp; India</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-islamic-history-culture">Islamic History &amp; Culture</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-british-history">British History</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-european-history">European History</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-history-of-usa">History of USA</a>&nbsp;</h6></li></ul></div></div>


<p></p><h3 class="heading "><span> </span></h3><br>
<div class="one_half "><div class="column_content "> <h3 class="heading "><span> GROUP V </span></h3><p></p>
<ul>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-gender-studies">Gender Studies</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-environmental-sciences">Environmental Sciences</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-agriculture-forestry">Agriculture &amp; Forestry</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-botany">Botany</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-zoology">Zoology</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-english-literature">English Literature</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-urdu-literature">Urdu Literature</a>&nbsp;</h6></li></ul></div></div>


<div class="one_half "><div class="column_content "> <h3 class="heading "><span> GROUP VI </span></h3><p></p>
<ul>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-law">Law</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-constitutional-law">Constitutional Law</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-international-law">International Law</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-muslim-law-jurisprudence">Muslim Law &amp; Jurisprudence</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-mercantile-law">Mercantile Law</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-criminology">Criminology</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-philosophy">Philosophy</a>&nbsp;</h6></li></ul></div></div>


<p></p><h3 class="heading "><span> </span></h3> <h3 class="heading "><span> GROUP VII </span></h3><p></p>
<ul>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-journalism-mass-communication">Journalism &amp; Mass Communication</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-psychology">Psychology</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-geography">Geography</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-sociology">Sociology</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-anthropology">Anthropology</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-punjabi">Punjabi</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-sindhi">Sindhi</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-pushto">Pushto</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-balochi">Balochi</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-persian">Persian</a></h6>
</li>
<li>
<h6><a href="compulsory_books_view.php?slug=<?= $slug; ?>-optional-arabic">Arabic</a></h6>
</li>
</ul>
<h3 class="heading "><span> </span></h3>
                </div>
                            </div>
            <div class="col-md-3 col-sm-4" style="height: auto !important; min-height: 0px !important;">
                
            </div>
        </div>
            </div>
        </div>
        <?php 
            include 'include/bottom_footer.php'; 
        ?>

        </div>
        <?php include 'include/footer.php';?>
    
    </body>
</html>