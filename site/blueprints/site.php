<?php if(!defined('KIRBY')) exit ?>

title: Site
fields:
  generalSettings:
    label: Site Settings
    type: headline
  title:
    label: Title
    type:  text
  description:
    label: Description
    type:  textarea
  logosvg:
    label: Custom Logo SVG
    type: select 
    options: files
    width: 1/3
  logopng:
    label: Custom Logo PNG
    type: image
    width: 1/3
  logowidth:
    label: Logo width (%)
    type: number
    min: 0
    max: 100%
    default: 30
    width: 1/3
  keywords:
    label: Keywords
    type:  tags
  customcss:
    label: Custom CSS
    type: textarea
    buttons: false
  googleAnalytics:
    label: Google Analytics ID
    type: text
    icon: code
    help: Tracking ID in the form UA-XXXXXXXX-X. Keep this field empty if you are not using it.
    width: 1/2
  ogimage:
    label: Facebook OpenGraph image
    type: image
    help: 1200x630px minimum
    width: 1/2