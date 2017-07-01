/**
 * sdfsdf
 */
var pages = [
 {
  id: 'a2',
  title: 'GoldenMan',
  parent: 'a3'
 },
 {
  id: 'a1',
  title: 'Travis',
  parent: null
 },
 {
  id: 'a3',
  title: 'Killer76XOXO',
  parent: null
 },
 {
  id: 'a4',
  title: 'Ololoshka',
  parent: 'a3'
 },
 {
  id: 'a5',
  title: 'Bear',
  parent: 'a3'
 },
 {
  id: 'a6',
  title: 'Cocojambo',
  parent: 'a4'
},
 {
  id: 'a7',
  title: 'Title 7',
  parent: null
 }
];

// form a tree

function getTreeForSelect(params) {

 params = params || {};

 params = {
  id: params.idSign || 'id',
  parent: params.parentSign || 'parent',
 }
  
 var objs = pages.reduce(function(prevValue, item) {

  prevValue[item[params.id]] = item;

  return prevValue;
 }, {});

 var tree = [];

 pages.forEach(item => {

  if (item[params.parent] == null) {

   tree.push(item);
  } else {

   if (objs[item[params.parent]]) {

    if( ! Array.isArray(objs[item[params.parent]].children) ) {

     objs[item[params.parent]].children = [];
    }

    objs[item[params.parent]].children.push(item);
   }
  }
 });

 var out = [];

 function createBranch(depth, item) {

  var children = item.children;

  delete item.children;
  item.title = (new Array(depth)).join('&nbsp;&nbsp;&nbsp;&nbsp;') + item.title;
  out.push(item);

  if (Array.isArray(children)) {

   children.forEach(createBranch.bind(null, depth + 1));
  }
 }

 tree.forEach(createBranch.bind(null, 1));

 return out;
}

getTreeForSelect(pages).forEach(item => {

 document.querySelector(".select").innerHTML += "<option>" + item.title + "</option>";
});
