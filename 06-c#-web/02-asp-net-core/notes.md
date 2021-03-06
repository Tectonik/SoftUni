# ASP.NET Core
## Introduction
- APS (Active Server Pages)
- Compared to ASP.NET MVC
	- Much less coupled to libraries
	- Not as monolithic
	- Uses NuGet for all components
	- Much faster
	- Not as tied to monolithic components
		- Modular
	- Uses JSON instead of XML by default
- View components
- Convention over configuration
- Model binding
- Model validation
	- Client-side
	- Server-side
- Middleware

### Service Types
- Scoped
	- New instance every request
- Transient
	- New instance every single time it's needed
- Static

### Razor
- View engine
- Avoid ViewBag and ViewData

### Controller
- Inherits Controller class
- Action
- Not static
- Can return *anything*
- Routing
	- Conventional
		- Recommended
	- Attribute routing
		- Not recommended
		- Makes tracing valid routes difficult
		- Harder debugging
	- The "/" symbol overrides the controller route
	- Constraint
		- Using ":"

#### Attributes
- [FromHeader]
- [NonAction]
- [ActionName]

### Validation
- ModelState.IsValid()

### Identity
- Authentication
- Authorization

## Razor Views
### Misc
- Partial views
- HTML Helpers
- Client gets only HTML
	- All logic is handled server-side
- Views have access to loads of stuff
- HSTS
- [DataType(DataType.MultilineText)]
- HTML helpers
	- Superseded by tag helpers
- Tag helpers
	- asp-for

### Special Files
- _Layout
	- @RenderBody()
	- this.Layout
- _ViewStart
- _ViewImports
- _ViewStart

### Keywords
- @using
- @model
- @inject
- @addTagHelper
	- Can add custom tag helpers
- @section

### Transfer to view
- ViewBag
	- Dynamic
	- Global
- ViewData
	- Dictionary
	- Global
- ViewModel
	- Better due to
		- Obvious description of data
		- Intellisense
		- Compilation errors
- ViewBag and ViewData are connected and share data

### HTML Helpers
- Tag helpers supersede these
- this.Html
	- .Editor()
		- .ForModel()
	- .BeginForm()
	- .Partial
		- .PartialAsync()
- @Html.ActionLink()

### Tag Helpers
- Use these instead of HTML Helpers
- <partial>
	- Model
	- Name

### View Components
- Partial view with attached code
- Shorthand possible
	- </> as instead of <></>
- Parts
	- Class
		- ViewComponent
	- Result
		- View
- Invoke
	- IViewComponentResult
	- InvokeAsync()
- Don't handle requests
- Typically initialize model
- Views location
	- Shared
		- Components
			- RegisteredStudentSomeDataViewModel
				- default.cshtml
- Usage
	- In code: MyCoolViewComponent
	- In cshtml: my-cool-view-component

### Interpretation
- Special symbols are HTML encoded
	- Can be avoided with @Html.Raw(data)
- String joined to @ is automatically interpreted as an email
	- Due to legacy reasons
	- Avoided with brackets ()
- To put a literal @, use @@
- @ -> code
- @: -> text
- Code by default unless a tag or @:

### Execution order
- Action
- View
- Layout

## Application Flow, Filters, and Middleware
### Misc
- TempData
- Controller
	- [Authorize(Role = "Admin")]
	- ControllerContext
		- ActionDescriptor
		- HttpContext
		- ModelState
		- RouteData
		- ValidProviderFactories
- Request
	- Id
		- For logging
	- Context
- Configuration providers
	- appsettings.json
		- .Development
		- .Production
	- launchsettings.json
- Don't forget to put  the project in the dev environment to get pretty error visualizations

#### Environments
- Dev
	-  Development
- Test
	- Testing & verification
- Stage
	- Customer tests
- Production
	- Release

### Application Flow
- Request
- Middleware
	- HTTP pipeline components
- Routing
	- Action
	- Page
- Controller initialization
	- Controller factory
	- Controller action invoker
- Action execution
	- Model binding
	- Model validation
	- Action
		- Filters
		- Execution
		- filters
		- result
- Result execution
	- Result
		- Filters
		- Execution
		- Filters
- View engine
- Response

### Error Handling
- Exception filter
- Model validation
	- ModelState
- Custom exception handling
	- app.UseExceptionHandler()
		- For exceptions
	- app.UseExceptionHandlerWithReExecute()
		- For non-exception errors
- Status code pages
	- app.UseStatusCodePagesWithRedirects()

### Middleware
- Software assembled into an app pipeline
- Each component
	- Handles requests and responses
	- Chooses whether to pass on to the next component or short-circuit
	- Can perform work before or after the next component in the pipeline
	- At invocation it receives the next component in the pipeline to decide whether to invoke it or not
		- Action<HttpContext, RequestDelegate> requestDelegate
	RequestDelegates build the pipeline
- Custom middleware class
- Registered in Configure()

#### Types
- Use()
	- Can short-circuit
	- Can pass to the next one
	- Can do work before or after the next one
- Run()
	- Terminates the pipeline
	- Runs last
- Map()
	- Branches the pipeline

#### Examples
```C#
public void Configure(IApplicationBuilder app, IWebHostEnvironment environment)
{
	// Route
	app.Map("/welcome", app =>
	{
		app.UseWelcomePage();

		app.Map("/someRoute", app => ...);
		app.Run(...);
	});

	// RequestDelegate 1
	app.Use(async (context, next)=>
	{
		await context.Response.WriteAsync("1");
		await next();
		await context.Response.WriteAsync("4");
	});

	// RequestDelegate 2
	app.Use(async (context, next)=>
	{
		await context.Response.WriteAsync("2");
		await next();
		await context.Response.WriteAsync("3");
	});

	// Always runs last
	app.Run(async (request)=>
	{
		await context.Response.WriteAsync("Always last");
	});
}
```

### Filters
#### Misc
- Run code before or after specific stages in the __Request Processing Pipeline__
- Come after the middleware
- Can be registered as an attribute
	- Put on controller, it applies to all actions
	- Can be put on a single action
- TypeFilterAttribute
- ServiceFilterAttribute
- Pattern: Chain of responsibility
- Can be
	- Synchronous
		- OnExecuting
		- OnExecuted
	- Asynchronous
		- OnExecutionAsync

#### Registration
- Global
	- Before and after every action
	- Startup.cs -> services.AddControllersWithViews(configure => configure.Filters.Add(new MyCustomFilter()));
	- Startup.cs -> services.AddControllersWithViews(configure => configure.Filters.Add(typeof (MyCustomFilter)));
- Attribute
	- : ActionFilterAttribute
	- : ExceptionFilterAttribute
	- : ResultFilterAttribute
	- : FormatFilterAttribute

#### Types
- Authorization
	- : IAuthorizationFilter
	- OnAuthorization
- Resource
	- : IResourceFilter
	- OnResourceExecuting
	- OnResourceExecuted
- Action
	- : IActionFilter
	- OnActionExecuting
	- OnActionExecuted
- Exception
	- : IExceptionFilter
	- OnExceptionExecuting
	- OnExceptionExecuted
- Result
	- : IResultFilter
	- OnResultExecuting
	- OnResultExecuted

#### Flow
- Request
- Middleware
- Authorization filters
- Resource filters
- Model binding/validation
- Action filters
- Action invocation
- Action filters
- Exception filters
- Result filters
- Result
- Result filters
- Resource filters
- Authorization filters
- Response

## Working with data
### Misc
- Unobtrusive javascript
- Validation
	- Server-side -> __always__
	- Client-side -> __optional__
- [MinLength()] always needs [Required]
	- Otherwise empty string is valid
- Model validation attributes
- validationContext -> class : ValidationAttribute
	- GetService()
	- Dependency injection
- RedirectToAction(nameof(controller))
- IFormFile
- IWebHostEnvironment
- IValidatableObject

### Model Binding
- HTTP request -> action method parameters
- Parameter name -> property name
	- From input name
- Query parameter
- Data sources (key : value)
	- Form values
		- enctype
			- urlencoded
			- multipart/form-data
				- For files
	- Route values
	- Query strings
	- Others
		- Headers
			- [FromHeader]
			- [FromHeader("header-name)]
		- Cookies
		- Sessions
	- [FromService]
	- [FromForm]
	- [FromBody]
	- [ModelBinder]
	- [Bind]
- ModelState
	- IsValid
	- ModelStateEntry
		- Errors
	- No exceptions, only errors
		- Invalid values are replaced by default
	- __All__ properties are validated
- Fills in arrays with query parameters
- asp-for
- asp-validation-summary
- [Display]
- [DataType]
- asp-items
	- @Html.GetEnumSelectList<MyEnum>()
- Client-side validation
	- <partial name="_ValidationScriptsPartial" />

## Workshop 1
- DTO vs ViewModel
	- DTO is used by services
	- ViewModel is used by views
- aps-append-version
	- Cache invalidation
- Controller -> Service -> Repository -> Entity Framework
- No tracking - EF stops tracking them

### Web
#### Infrastructure
	- TagHelpers
	- Filters
	- Middleware
	- Validation attributes
	- Not directly related to presentation, controllers, or views
#### Areas
- Controllers and views
- {MyArea}/Controller/Action
### Tests
### Data
	- DbContext
	- Migrations
### Services
	- Business logic
#### Data
	- Services that deal with data

## Web API
### Important JS Frameworks
- Angular
- Vue.js
- React

### Misc
- Fonts
	- Icon only fonts
- RoleManager
- db.Entry()
- JWT

### JSON
- Scripting language
	- Executed line by line
- JavaScript object notation
- Open file format
- Common
- MIME
	- application/json
- Extension
	- .json
- No schemas
- No namespaces

### XML
- Extensible markup language
- MIME
	- application/xml (current)
	- text/xml (old)
- Extension
	- .xml
- Schemas
- Namespaces
- XHTML

### JavaScript
- HTML
- CSS
- TypeScript

### AJAX
- Asynchronous JavaScript and XML
- XHR
	- XmlHttpRequest

### ASP.NET Core Web API
- [assembly: ApiController]
- [ApiController]
	- Filters
	- Automatic validation and BadRequest(400) on bad data
		- ModelStateInvalidFilter
	- Automatic Binding
	- Additional functionality
- Route("api/[controller]")
	- Necessary
	- API controller actions always execute on the same controller route
- [HttpPost("{id}")]
- Normal controllers inherit Controller
- API controllers inherit ControllerBase
- Validation attibutes on actions
- Complex types
	- Searched in body as json
- Primitive types
	- Searched in query string
- .AddXmlSerializerFormatters()
- [Authorize]
- [ProducesResponseType(200)]
- OData
	- [EnableQuery()]
- OpenApi
- return this.CreatedAtAction(parameters...)

### Angular
- SPA
- PWA
- Mobile (native)
	- Cordova
	- Ionic
- Desktop
	- Electron
- Two-way data-binding

### CORS
- Cross-origin resource sharing
- Browser only feature
- Origin
	- Address schema
	- Domain/host
	- Port
- Allows specific sites to make calls (Unlike SOP)
- SOP
	- Prevents making requests to domains other than the one that served the page
- Configuration
	- Startup.cs
- Web app and web API on different addresses?
	- Enable CORS

## Security and identity

### Misc
- PageModel
- IHttpContextAccessor
	- Accessing user in service
		- Not a good way. Avoid

### Security

#### SQL Injection
- Escaping
- Parameterized queries
- Interpolated string
- Never concatenate raw strings

#### Cross-Site Scripting (XSS)
- [IgnoreAntiForgeryToken]
- Never trust user data
- When unescaped user data is accepted by the server
	- Allows code to be sent
- Avoid HTML.Raw()
- Set cookie as HTTP only
- Use Razor
- Data should be:
	- Encoded
	- Parsed
	- Validated
	- Checked for malicious content
- Encoding
	- Services
		- HtmlEncoder
		- JavaScriptEncoder
		- UrlEncoder
	- Static
		- WebUtility.HtmlEncode & .HtmlDecode
		- WebUtility.UrlEncode & .UrlDecode
- Libraries
	- HtmlSanitizer

#### Parameter Tampering
- Manipulation of parameters exchanged between client and server
	- Example: Looping through all values for given parameter

#### Cross-Site Request Forgery
- SameSite cookie parameter
- Request verification token
	- [ValidateAntiForgeryToken]
	- configure.Filters.Add(new AutoValidateAutoForgeryToken())

#### DDoS

#### Insufficient Access Control
- [Authorize(Role="MyRole")]

#### Too Much Information In Errors

#### Missing SSL / Man In The Middle

#### Phishing / Social Engineering

### Identity
- [AllowAnonymous]
- [Authorize(Roles = "Admin")]
	- On action
	- On controller
	- On parent controller - all inheritors get the attribute
	- Attribute on action is prioritized over attribute on controller
- GDPR
- Microsoft.AspNetCore.Identity.EntityFrameworkCore
- Microsoft.AspNetCore.Identity.UI
- services.AddDefaultIdentity
- UseAuthentication
- Users
	- SignInManager
	- UserManager
		- Use this when dealing with users
	- RoleManager
- Roles are recorded in cookies, so re-login if you change their roles
- .AddRoles<IdentityRole>()

#### Claims
- Key-value pairs
- Additional information only some user have
- Policy-based

#### Policies
- options.AddPolicy()

#### Extending And Scaffolding
- Files in project take precedence over files from libraries

### Authentication
- UseAuthorization
- Types
	- Cookie-based
	- Windows auth
	- Cloud-based

### JWT
- JSON web token
- ConfigureServices()
	- Middleware
- Header instead of cookie
- Common in REST
- Used for representing claims between two parties
- Encrypted
- Stateless
- Structure
	- Headers
	- Payload (data)
	- Verification signature
	- Separated by "."

### Social Accounts
- External login provider
- Third party manages the sign-in
- Example: "Login with Google"
- Example: Microsoft.AspNetCore.Authentication.Facebook

## Testing

### Misc
- Testing features before delivering to clients
- Testing business logic first and foremost
- Services are important
- Different application components are tested differently
- Test types
	- Unit tests
	- Integration testing
	- End-to-End testing
- AAA
	- Arrange
	- Act
	- Assert

### Test levels
#### Unit
	- Specific code in a component
#### Component
	- Specific component
#### Integration
	- Whether multiple components work together
#### System
	- The system as a whole
#### Regression
	- Previously fixed bugs won't reappear
#### Acceptance
	- Client's requirements
#### Performance / Load / Stress
	- Performance
		- Are queries executed in a given time
	- Load
		- App should work even under heavy stress
	- Stress
		- Abnormal situations
		- App appears over our app
		- Battery testing
		- Server restarting
		- Etc
#### Security
	- Security flaws
	- Both automated and manual testing
#### Other
	- Manual
	- Automation
	- UI
	- Smoke
		- Happy path
	- Black box
		- Testing with no access to the code base
	- End-to-End
	- A/B
		- Separate into groups

### Approaches
- Code-first
	- Fast
	- Flexible
- Test-first
	- Tests based on code
	- Quality
	- Edge cases
	- Complicated
	- Initial delay

### Unit Testing
- xUnit
- Tests should be independent from each other

#### Mocking
- Moq

#### In-Memory Database
- Microsoft.EntityFrameworkCore.InMemory
- Non-relational
- No relations

### Integration Testing
- Components function correctly at the infrastructure level
- Components work together correctly and return expected results
- More complicated than unit tests
- Microsoft.AspNetCore.Mvc.Testing

### Selenium
- Web browser simulation
- Headless
- Drivers
	- Chrome
	- Firefox
	- Edge
	- Internet Explorer
	- Etc
- Portable
- Automates browsers
- Verify browser and package version match

#### Integration

### MyTested.AspNetCore.Mvc
- Controller testing
- Automatic resolving of test dependencies
- Fluent API
- Strongly-typed extensions
- Built-in mocks

## Project Architecture

### Misc
- Stateless service
	- Takes data and returns response without reading or writing anywhere
- Serverless
	- One action

### Design
- Web vs Desktop vs Mobile vs IoT
#### Multi-Page App
#### Single-Page App

### Architecture
#### Monolithic
- Single-tiered apps
- UI and data code are combined
- Simplest architecture
- Easy deployment and maintenance
	- Due to lack of modularity and complexity
- For small and mid-sized projects

#### Service-Oriented
- Split project into smaller applications
- Communication over SOAP/XML/WS
- All services share data store
- Services do multiple activities in the scope of a single functionality

#### Microservices
- Lots of small applications
- Direct communication between microservices
- Services can be deployed independently
- Microservices have their own data stores
- Docker
- Kubernetes

### ASP.NET Core MVC vs Razor Pages
#### Razor Pages
- MVVM
- Combines model and controller into page model
- Similar to view component
- Single responsibility
- For simple applications
- Razor page
	- View template (.cshtml)
	- Code behind (.cs) as the controller

### Automapper
- Works by matching property names and types
- ConfigureServices

### Repository Pattern
- Encapsulates data access logic
- You define one repository per entity
	- Example: StudentRepository
- Interface IRepository

### Database and ORM
#### ORM
- Object relational mapper
- Layer between DB and application
- Maps data to relational objects
- Unit of work (DbContext)
- Tracks changes
- Performance cost

#### Dapper
- Micro ORM
	- Limited functionality
- High performance
- String queries
	- Close to the metal

#### Databases
- Very important decision in development
- Types
	- Relational
		- Use SQL
		- Performance penalty due to checks
	- Non-relational
		- Faster
		- Dynamic schema
		- No triggers
			- Data and type may differ from record to record
		- No data validation

## Advanced Topics

### Misc
- Post-Redirect-Get design pattern
	- Should be used

### Host Class
- At minimum, configures a server and request pipeline
- Can also set up
	- Logging
	- Dependency injection
	- Configuration
- Configured in entry point
- Accepts the startup file
- IHostBuilder
- Kestrel
	- ASP.NET Core integrated web server
	- CreateDefaultBuilder()

### Logging
- Event log
- Log filters
- Minimum log level
- Log levels
	- Not technology specific
- Logging providers
	- Possibly multiple
- appsettings.json

#### Structure
- ILogger
	- Create log messages
	- ILoggerFactory
	- Create ILogger instances
- ILoggerProvider
	- How and where logs go
	- Format of the logger

### Cache
- ASP.NET Core supports different caches
#### IMemoryCache
- In-memory
- Service
	- services.AddMemoryCache()
- MemoryCacheEntryOptions
	- SlidingExpiration
- When running out of memory, the server will start to evict items from the cache regardless of expiration

#### IDistributedCache
- Microsoft.Extensions.Caching.SqlServer
- Shared by multiple servers
- Usually stored in a database
- Connection string
- Tag helper <cache></cache>

#### HTTP Response Cache
- Cache-control
- You can't force a browser to cache, but you can force it to not cache

### Sessions
- Unique identifier that stores data
- Temporary user data storage
- Session ID
- Backed by server cache

### TempData
- Store data until reading
	- Keep()
	- Peek()
- Cookies(default) or Session
- TempData providers
- This.TempData[]

### Areas
- Areas folder
- Visual Studio -> Add -> Area
- Order a large number of components into folders
- Areas include:
	- Controllers
	- Models
	- Views
- [Area("...")]
- >2:50 video
- ViewImports

### Performance
- DotTrace
- Low-hanging fruit
- Use async/await
- Enable compression
	- services.AddResponseCompression()
	- app.UseResponseCompression()
- Reduce HTTP Requests
	- Bundling
		- bundleconfig.json
		- BuildBundlerMinifier
- Minification
- HTTP/2 over SSL
	- Enabled by default
- Multiplexing
- Load CSS first
	- Put CSS in the head
- Load JS last
	- Put JS in the body
- CDN
- Caching pages

### SEO
- Single-page apps are difficult to crawl and sometimes ignored by Google
- Meaningful URLs
	- Slug
- Useful metadata
	- Title
	- keywords
		- <meta name="keywords"></meta>
	- Description

### GDPR
- General Data Protection Regulation
- EU directive
- Addresses data protection and privacy
- Private data
	- Anything that can be used to uniquely identify someone
- ASP.NET Core APIs
- Rights to provide:
	- To be informed
	- Access
	- Rectification
	- Erasure
	- Restrict processing
	- Portability
	- Object
	- Related to automatic decision making
	- Cookie consent
