# -*- coding: utf-8 -*-
#
# MongoDB documentation build configuration file, created by
# sphinx-quickstart on Mon Oct 3 09:58:40 2011.
#
# This file is execfile()d with the current directory set to its containing dir.

import sys
import os.path
import datetime

from giza.config.runtime import RuntimeStateConfig
from giza.config.helper import fetch_config, get_versions, get_manual_path

from sphinx.errors import SphinxError

conf = fetch_config(RuntimeStateConfig())
sconf = conf.system.files.data.sphinx_local

sys.path.append(os.path.join(conf.paths.projectroot, conf.paths.buildsystem, 'sphinxext'))

# -- General configuration ----------------------------------------------------

needs_sphinx = '1.0'

extensions = [
    'sphinx.ext.extlinks',
    'sphinx.ext.todo',
    'mongodb',
    'directives',
    'intermanual'
]

templates_path = ['.templates']
exclude_patterns = []

source_suffix = '.txt'

master_doc = sconf.master_doc
language = 'en'
project = sconf.project
copyright = u'2008-present'

version = conf.version.branch
release = conf.version.release

rst_epilog = '\n'.join([
    '.. |branch| replace:: ``{0}``'.format(conf.git.branches.current),
    '.. |copy| unicode:: U+000A9',
    '.. |year| replace:: {0}'.format(datetime.date.today().year),
    '.. |ent-build| replace:: MongoDB Enterprise',
    '.. |hardlink| replace:: http://docs.mongodb.com/php-library/',
    '.. |checkmark| unicode:: U+2713',
    '.. |php-library| replace:: MongoDB PHP Library'
])

extlinks = {
    'issue': ('https://jira.mongodb.org/browse/%s', '' ),
    'manual': ('http://docs.mongodb.org/manual%s', ''),
    'php': ('http://php.net/%s', '')
}

## add `extlinks` for each published version.
for i in conf.git.branches.published:
    extlinks[i] = ( ''.join([ conf.project.url, '/', i, '%s' ]), '' )

intersphinx_mapping = {}

intersphinx_mapping = {}
for i in conf.system.files.data.intersphinx:
    intersphinx_mapping[i.name] = ( i.url, os.path.join(conf.paths.projectroot,
                                                        conf.paths.output,
                                                        i.path))

languages = []

pygments_style = 'default'


# -- Options for HTML output ---------------------------------------------------

html_theme = sconf.theme.name
html_theme_path = [ os.path.join(conf.paths.buildsystem, 'themes') ]
html_title = conf.project.title
htmlhelp_basename = 'MongoDB'

html_logo = ".static/logo-mongodb.png"
html_static_path = sconf.paths.static

html_copy_source = False
html_domain_indices = True
html_use_index = True
html_split_index = False
html_show_sourcelink = False
html_show_sphinx = True
html_show_copyright = True
html_add_permalinks = ''

html_theme_options = {
    'branch': conf.git.branches.current,
    'manual_path': get_manual_path(conf),
    'translations': languages,
    'language': language,
    'repo_name': sconf.theme.repo,
    'jira_project': sconf.theme.jira,
    'google_analytics': sconf.theme.google_analytics,
    'project': sconf.theme.project,
    'version': version,
    'version_selector':  get_versions(conf),
    'active_branches': conf.version.active,
    'stable': conf.version.stable,
    'sitename': sconf.theme.sitename,
    'nav_excluded': sconf.theme.nav_excluded,
    'upcoming': 'master'
}

html_sidebars = sconf.sidebars


# -- Options for Epub output ---------------------------------------------------

# Bibliographic Dublin Core info.
epub_title = conf.project.title
epub_author = u'MongoDB Documentation Project'
epub_publisher = u'MongoDB, Inc.'
epub_copyright = copyright
epub_theme = 'epub_mongodb'
epub_tocdup = True
epub_tocdepth = 3
epub_language = 'en'
epub_scheme = 'url'
epub_identifier = 'http://www.mongodb.com/docs/php-library/'
epub_exclude_files = []
epub_pre_files = []
epub_post_files = []
