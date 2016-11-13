<?php if(!defined('KIRBY')) exit ?>

title: Home
files: true
pages: false
fields:
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
               <td>Image size</td>
               <td>Height</td>
               </tr>
               <tr>
               <td style="width:20%"><img src="{{_thumb}}" width="80px"><br>{{content}}</td>
               <td>{{imageposition}}</td>
               <td>{{caption}}</td>
               <td>{{captionposition}}</td>
               <td>{{imagesize}}</td>
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
            help: 0 to center +/- 100 to align right or left
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
          imagesize:
            label: Image size
            type: fieldtoggle
            default: custom
            width: 1/2
            options:
              full: Fullscreen 
              custom: Custom
            show:
              full: contain
              custom: height
            hide:
              full: height
              custom: contain
          height:
            label: Height (%)
            type: number
            default: 100
            min: 0
            required: true
            width: 1/2
          contain:
            label: Contain image
            type: toggle
            default: no
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
            label: Caption position
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