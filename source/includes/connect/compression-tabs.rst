.. tabs::

   .. tab:: MongoDB\\Client
      :tabid: mongoclient

      .. code-block:: php

         $client = new MongoDB\Client(
            'mongodb://<hostname>:<port>',
            ['compressors' => 'snappy,zstd,zlib'],
         );

   .. tab:: Connection String
      :tabid: connectionstring

      .. code-block:: php

         $uri = 'mongodb://<hostname>:<port>/?compressors=snappy,zstd,zlib';
         $client = new MongoDB\Client($uri);