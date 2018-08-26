# SlabPHP Bundle Stack Library

This library maintains a stack of SlabPHP bundles and allows a form of polymorphism within the framework while also managing what SlabPHP calls cascading file resource directories.

Please see the main SlabPHP documentation for more information about SlabPHP and the reason why these libraries exist.

## Installation

Use composer to include the package

    composer require slabphp/bundle-stack
    
## Usage

### Initialization

Make sure your SlabPHP bundle configuration object exists. SlabPHP has one built-in for it's default Bundle. That's the one you should use as the first one but of course it's not required if you're for some reason using this library not within a SlabPHP context.

    $stack = new \Slab\Bundle\Stack();
    
Then you can push bundle configuration objects for any other bundle you've created.

    $stack
        ->pushBundle(new \SlabPHP\Configuration())
        ->pushBundle(new \My\Shared\Namespace\Configuration())
        ->pushBundle(new \My\Site\Configuration());
    
SlabPHP offers the ability to push your final bundle configuration by using dynamic means, such as a server_name. This logic is not handled in this library.

### Finding a Class

You can now use your bundle stack to locate appropriate classes. For example, if you have a second-tier shared bundle, you could make it query the bundle stack using the findClass or findClassName methods.

For example, lets assume your bundle stack looks like the following:

* Slab - default bottom bundle
* Shared - your shared bundle
* Example - your example.com site bundle

You have already created Bundle configuration objects for them and build a $this->stack object.

To continue with this example, assume you have a \Shared\Controllers\Article class. Inside of this class you do the following:

    $object = $this->stack->findClass('Utilities\Calendar');
    
The stack object will look for \Example\Utilities\Calendar first, if it exists, it will use it, otherwise it will check for \Shared\Utilities\Calendar, and finally it will check for \Slab\Utilities\Calendar before either returning a found class instance or null. Alternatively you can just use findClassName if you just want a string representation of the name. This functionality relies on the presence of a previously configured autoloader (hopefully psr4) to be present.

### Cache

Everything gets stored in a local thread-only memory cache. This will optimize repeated look-ups within the same request but has to be rebuilt every request. If you find this is an issue, consider forking.