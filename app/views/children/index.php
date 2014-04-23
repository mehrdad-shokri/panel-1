<?php echo $header ?>

<div class="content manager">

  <header class="manager__header">
    <h1 class="alpha">Manage subpages for <a ui-sref="page({uri: page.uri})">{{page.title}}</a></h1>
    <a class="manager__back" ui-sref="page({uri: page.uri})"><i class="fa fa-arrow-circle-left"></i> Back to page</a>
    <a ng-show="page.children.length > 0" class="manager__toggle" ui-sref="children.modal.add">
      <i class="fa fa-plus-circle"></i> <span>Add a new subpage</span>
    </a>
  </header>

  <div ng-show="page.children.length > 20" class="manager__search">
    <input class="manager__searchinput" type="search" ng-model="search" placeholder="Search for a subpage…">
  </div>

  <div class="subpages" ng-show="page.children.length != 0">

    <div class="grid">
      <div class="grid__item" ng-class="visibleClass">

        <h2 class="beta">Visible subpages</h2>

        <ul id="visible-children" class="sortable">
          <li id="{{child.uid}}" ng-dblclick="$state.go('page', {uri: child.uri})" class="subpage" ng-class="{deletable: dropdown.isOpen('subpage-' + child.uid)}" ng-repeat="child in visibleChildren | filter: {title: search}">
            <strong>{{child.title}}</strong>
            <small class="num">{{child.num}}</small>

            <a class="subpage__editToggle" ui-sref="page({uri: child.uri})">
              <i class="fa fa-pencil"></i>
            </a>

            <a class="subpage__deleteToggle" ng-click="dropdown.toggle('subpage-' + child.uid, $event)">
              <i ng-show="!dropdown.isOpen('subpage-' + child.uid)" class="fa fa-trash-o"></i>
              <i ng-show="dropdown.isOpen('subpage-' + child.uid)" class="fa fa-times"></i>
            </a>

            <form ng-show="dropdown.isOpen('subpage-' + child.uid)" class="dropdown subpage__dropdown" ng-submit="delete(child)">
              <input class="form__button form__button--submit" type="submit" value="delete">
            </form>
          </li>
        </ul>

        <div class="subpages__hint subpages__hint--left" ng-show="visibleChildren.length == 0">
          Drag pages from the right here to sort them/make them visible.
        </div>

      </div><!--

   --><div class="grid__item" ng-class="invisibleClass">

        <h2 class="beta">Invisible subpages</h2>

        <ul id="invisible-children" class="sortable">
          <li id="{{child.uid}}" ng-dblclick="$state.go('page', {uri: child.uri})" class="subpage" ng-class="{deletable: dropdown.isOpen('subpage-' + child.uid)}" ng-repeat="child in invisibleChildren | filter: {title: search}">
            <strong>{{child.title}}</strong>
            <small class="num">—</small>

            <a class="subpage__editToggle" ui-sref="page({uri: child.uri})">
              <i class="fa fa-pencil"></i>
            </a>

            <a class="subpage__deleteToggle" ng-click="dropdown.toggle('subpage-' + child.uid, $event)">
              <i ng-show="!dropdown.isOpen('subpage-' + child.uid)" class="fa fa-trash-o"></i>
              <i ng-show="dropdown.isOpen('subpage-' + child.uid)" class="fa fa-times"></i>
            </a>

            <form ng-show="dropdown.isOpen('subpage-' + child.uid)" class="dropdown subpage__dropdown" ng-submit="delete(child)">
              <input class="form__button form__button--submit" type="submit" value="delete">
            </form>
          </li>
        </ul>

        <div class="subpages__hint subpages__hint--right" ng-show="invisibleChildren.length == 0">
          Drag pages from the left here to unsort them/make them invisible.
        </div>

      </div>
    </div>

  </div>

  <div class="manager__empty" ng-show="page.children.length == 0">
    <a ui-sref="children.modal.add" href="">
      <i class="fa fa-plus-circle fa-lg"></i> <span>Add your first subpage</span>
    </a>
  </div>

</div>