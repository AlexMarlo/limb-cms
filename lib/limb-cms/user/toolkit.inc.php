<?php

lmb_require('limb/toolkit/src/lmbToolkit.class.php');
lmb_require('limb-cms/user/src/toolkit/UserTools.class.php');
lmbToolkit :: merge(new UserTools());