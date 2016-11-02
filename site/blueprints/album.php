<?php if(!defined('KIRBY')) exit ?>

title: Album
files: true
pages: false
fields:
  title:
    label: Title
    type:  text
    width: 3/4
  externallink:
    label: External Link
    type: url
    width: 1/4
  titleformatting:
    label: Title formatting
    type: checkboxes
    options:
      italic: Italic
      comma: Add comma
      clear: New line afterwards
    columns: 1
    width: 1/2
  featured:
    label: Featured image
    type: image
    width: 1/2
  text:
    label: Description
    type: textarea
  gallery:
    label: Gallery
    type: builder
    fieldsets:
      image:
        label: Image
        entry: >
               <table style="width:100%; font-size: 11px">
               <tr>
               <td style="width:20%">Image</td>
               <td>Image position</td>
               <td>Caption</td>
               <td>Caption position</td>
               <td>Height</td>
               </tr>
               <tr>
               <td style="width:20%"><img src="{{_fileUrl}}{{content}}" width="80px"><br>{{content}}</td>
               <td>{{imageposition}}</td>
               <td>{{caption}}</td>
               <td>{{captionposition}}</td>
               <td>{{height}}</td>
               </tr>
               </table>
        fields:
          content:
            label: Image
            type: image
            width: 1/2
          caption:
            label: Caption
            type: textarea
            width: 1/2
          imageposition:
            label: Image position
            type: number
            default: 0
            required: true
            min: -100
            max: 100
            help: 0 to center
            width: 1/2
          captionposition:
            label: Caption position
            type: number
            default: 0
            required: true
            min: -50
            max: 50
            help: 0 to center
            width: 1/2
          height:
            label: Height (%)
            type: number
            default: 100
            min: 0
            help: Leave empty for fullscreen
            width: 1/2
      video:
        label: Video
        entry: >
               <table style="width:100%; font-size: 11px">
               <tr>
               <td style="width:20%">Video ID</td>
               <td>Video position</td>
               <td>Caption</td>
               <td>Caption position</td>
               <td>Width</td>
               </tr>
               <tr>
               <td style="width:20%">{{content}}</td>
               <td>{{imageposition}}</td>
               <td>{{caption}}</td>
               <td>{{captionposition}}</td>
               <td>{{width}}</td>
               </tr>
               </table>
        fields:
          content:
            label: Video
            type: text
            help: Youtube/Vimeo ID
            width: 1/2
          caption:
            label: Caption
            type: textarea
            width: 1/2
          imageposition:
            label: Video position
            type: number
            default: 0
            required: true
            min: -100
            max: 100
            help: 0 to center
            width: 1/2
          captionposition:
            label: Video position
            type: number
            default: 0
            required: true
            min: -50
            max: 50
            help: 0 to center
            width: 1/2
          width:
            label: Width (%)
            type: number
            default: 100
            min: 0
            width: 1/2
      layout:
        label: Page Layout
        entry: >
               <table style="width:100%; font-size: 11px">
               <tr>
               <td style="width:20%">Page Layout</td>
               </tr>
               <tr>
               <td style="width:20%">{{content}}</td>
               </tr>
               </table>
        fields:
          layout:
            label: SVG/PNG layout
            type: select
            options: query
            required: true
            query:
              page: index
              fetch: files
              value: '{{filename}}'
              text: '{{filename}}'