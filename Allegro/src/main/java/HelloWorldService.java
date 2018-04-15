
import java.util.Collections;
import java.util.Map;
import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

@Path("/HelloWorld")
public class HelloWorldService {

	@GET
	@Path("/sayHello")
	public String sayHello() {
		return "<h1>Hello World from REST in My Home</h1>";
	}
		
	@GET
	@Path("/sayHello/{name}")
	@Produces(MediaType.APPLICATION_JSON)
	public Response sayHello(@PathParam("name") String name) {
		Map<String, String> response = Collections.singletonMap(
				"Message", "Hello " + name + "!");
		return Response.ok(response).build();
	}
	
}