<?php $cat = $this->uri->segment(2);?>
<div id="sidebar">
  <ul class="side-nav accordion_mnu collapsible">
    <li><?php echo anchor('admin', '<span class="white-icons computer_imac"></span> Dashboard'); ?></li>
    <li><a href="#" class="<?php if($cat == 'entertainment_sansar') echo 'active';?>"><span class="white-icons list "></span> Entertainment Sansar</a>
      <ul class="acitem">
        <li><?php echo anchor('admin/entertainment_sansar/jokes', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Jokes'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/poems', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Poems'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/stories', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Stories'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/recipes', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Cooking Recipes'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/faceweek', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Face of the week'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/talk', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Coffee Talk'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/events', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Events'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/chat', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Chat'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/games', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Online Games'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/poems', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Online FM'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/poems', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Online TV'); ?></li>
        <li><?php echo anchor('admin/entertainment_sansar/quiz', '<span class="sidenav-icon"><span class="sidenav-link-color"></span></span>GK Test'); ?></li>
      </ul>
    </li>
    <li><a href="#"><span class="white-icons cup"></span> Result Sansar</a>
      <ul class="acitem">
        <li><a href="typography.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>SLC Result</a></li>
        <li><a href="widgets.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>HSEB Result</a></li>
        <li><a href="widgets.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>TU Result</a></li>
      </ul>
    <li><a href="#"><span class="white-icons book"></span> Study Sansar</a>
      <ul class="acitem">
        <li><a href="typography.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Subject Note</a></li>
        <li><a href="widgets.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Question Bank</a></li>
        <li><a href="grid.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Thesis</a></li>
        <li><a href="button-icons.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Reports</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Project Works</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Routines</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Notices</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Syllabus</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Articles</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Edu. Tips</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Education News</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Education Videos</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Scholarship Updates</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>E-Resources</a></li>
        <li><a href="ui-elements.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Application Forms</a></li>
    </ul>
    </li>
    <li><a href="#"><span class="white-icons shuffle"></span> Support Sansar</a>
      <ul class="acitem">
        <li><a href="table.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Tenz Problems</a></li>
        <li><a href="chart.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Ask an Expert</a></li>
        <li><a href="file-explorer.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Query us</a></li>
      </ul>
    </li>
    <li><a href="#"><span class="white-icons briefcase"></span> Your Sansar</a>
      <ul class="acitem">
        <li><a href="inbox.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Sell your things</a></li>
        <li><a href="content.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Gadget Zones</a></li>
        <li><a href="login.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Job Search</a></li>
      </ul>
    </li>
    <li><a href="#"><span class="white-icons documents"></span> Directory Sansar</a>
      <ul class="acitem">
        <li><a href="inbox.html"><span class="sidenav-icon"><span class="sidenav-link-color"></span></span>Directory Sansar</a></li>
      </ul>
    </li>
  </ul>
  <div id="side-accordion">
    <div class="accordion-group">
      <div class="accordion-header"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#side-accordion" href="#collapseOne"><i class="nav-icon month_calendar"></i> Today's event</a> </div>
      <div id="collapseOne" class="collapse in">
        <div class="accordion-content">
          <ul class="event-list">
            <li>
              <div class="evnt-date"> 31<span>July</span> </div>
              <div class="event-info"> <span><i class="icon-time"></i> 12:25 PM</span>
                <p> Anim pariatur cliche repreh enderit, enim eiusmod high life </p>
              </div>
            </li>
            <li>
              <div class="evnt-date"> 31<span>July</span> </div>
              <div class="event-info"> <span><i class="icon-time"></i> 2:35 PM</span>
                <p> Anim pariatur cliche repreh enderit. </p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="accordion-group">
      <div class="accordion-header"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#side-accordion" href="#collapseTwo"><i class=" nav-icon graph"></i> Site Statistics</a> </div>
      <div id="collapseTwo" class="collapse">
        <div class="accordion-content">
          <div class="site-stat">
            <h5><i class="icon-signal"></i> Visit Rates</h5>
            <ul>
              <li>Avarage Traffic<span class="up">35K</span></li>
              <li>Visitors<span class="down">5%</span></li>
              <li>Conversation Rate<span class="up">10m</span></li>
            </ul>
            <h5><i class="icon-align-left"></i> Unique Visit</h5>
            <ul>
              <li>Visit Rate<span class="up">14K </span></li>
              <li>Bounce Rate<span class="up">10K </span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="new-update">
    <h2><i class="icon-list-alt"></i> Recent Update</h2>
    <div class="side-news">
      <h5><a href="#">Released Ziown Admin</a></h5>
      <p> ZiOwn is a powerful and clean admin panel template for web entrepreneurs, app developers and site owners as this can be used for the admin part of any web application, web based software's or custom CMS admin panels. It is very easy to use and extremely easy to integrate ... </p>
    </div>
    <div class="side-news">
      <h5><a href="#">Released Bingo Admin</a></h5>
      <p> Bingo is very powerful high end admin/backend user interface template. You can use it ... </p>
    </div>
  </div>
</div>